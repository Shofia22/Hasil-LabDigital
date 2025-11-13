<?php

namespace App\Http\Controllers;

use App\Models\LabResult;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LabController extends Controller
{
    /**
     * Show the lab dashboard
     */
    public function dashboard()
    {
        $pendingResults = Auth::user()->labResults()->where('status', 'pending')->count();
        $completedResults = Auth::user()->labResults()->where('status', 'completed')->count();
        $myResults = Auth::user()->labResults()->with(['patient', 'doctor'])->orderBy('created_at', 'desc')->get();
        
        return view('lab.dashboard', compact('pendingResults', 'completedResults', 'myResults'));
    }

    /**
     * View all lab results created by this lab staff
     */
    public function labResults()
    {
        $labResults = Auth::user()->labResults()->with(['patient', 'doctor'])->get();
        return view('lab.lab-results', compact('labResults'));
    }

    /**
     * View a specific lab result created by this lab staff
     */
    public function viewLabResult($id)
    {
        $labResult = LabResult::with(['patient', 'doctor'])->findOrFail($id);
        if ($labResult->lab_staff_id !== Auth::id()) {
            abort(403);
        }
        return view('lab.view-lab-result', compact('labResult'));
    }

    /**
     * Show the form to create a new lab result
     */
    public function createLabResult()
    {
        $patients = User::where('role', 'patient')->get();
        $doctors = User::where('role', 'doctor')->get();
        
        return view('lab.create-result', compact('patients', 'doctors'));
    }

    /**
     * Store a new lab result
     */
    public function storeLabResult(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:users,id',
            'doctor_id' => 'required|exists:users,id',
            'test_type' => 'required|string|max:255',
            'result_value' => 'required|string',
            'result_file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240', // 10MB max
        ]);

        $resultFile = null;
        if ($request->hasFile('result_file')) {
            $resultFile = $request->file('result_file')->store('lab-results', 'public');
        }

        LabResult::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'lab_staff_id' => Auth::id(),
            'test_type' => $request->test_type,
            'result_value' => $request->result_value,
            'result_file' => $resultFile,
            'status' => 'pending', // Default to pending for doctor review
        ]);

        // Create notification for the assigned doctor
        \App\Models\Notification::create([
            'user_id' => $request->doctor_id,
            'message' => 'A new lab result is pending your review',
        ]);

        \App\Models\ActivityLog::log(Auth::id(), 'Created lab result for patient ID: ' . (string) $request->patient_id);
        return redirect()->route('lab.lab-results')->with('success', 'Lab result created successfully.');
    }

    /**
     * Show the form to edit a lab result
     */
    public function editLabResult($id)
    {
        $labResult = LabResult::findOrFail($id);
        $patients = User::where('role', 'patient')->get();
        $doctors = User::where('role', 'doctor')->get();
        
        return view('lab.edit-result', compact('labResult', 'patients', 'doctors'));
    }

    /**
     * Update a lab result
     */
    public function updateLabResult(Request $request, $id)
    {
        $request->validate([
            'patient_id' => 'required|exists:users,id',
            'doctor_id' => 'required|exists:users,id',
            'test_type' => 'required|string|max:255',
            'result_value' => 'required|string',
            'status' => 'required|in:pending,reviewed,completed',
            'result_file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240', // 10MB max
        ]);

        $labResult = LabResult::findOrFail($id);

        $resultFile = $labResult->result_file;
        if ($request->hasFile('result_file')) {
            // Delete old file if exists
            if ($labResult->result_file) {
                Storage::disk('public')->delete($labResult->result_file);
            }
            
            $resultFile = $request->file('result_file')->store('lab-results', 'public');
        }

        $labResult->update([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'test_type' => $request->test_type,
            'result_value' => $request->result_value,
            'result_file' => $resultFile,
            'status' => $request->status,
        ]);

        // Create notification for the assigned doctor if status changes
        if ($request->status === 'completed') {
            \App\Models\Notification::create([
                'user_id' => $request->doctor_id,
                'message' => 'A lab result has been marked as completed and is ready for review',
            ]);
        }

        \App\Models\ActivityLog::log(Auth::id(), 'Updated lab result ID: ' . (string) $labResult->id);
        return redirect()->route('lab.lab-results')->with('success', 'Lab result updated successfully.');
    }

    /**
     * Delete a lab result
     */
    public function deleteLabResult($id)
    {
        $labResult = LabResult::findOrFail($id);

        // Delete file if exists
        if ($labResult->result_file) {
            Storage::disk('public')->delete($labResult->result_file);
        }

        $labResult->delete();

        \App\Models\ActivityLog::log(Auth::id(), 'Deleted lab result ID: ' . (string) $id);

        return redirect()->route('lab.lab-results')->with('success', 'Lab result deleted successfully.');
    }

    /**
     * Download result file
     */
    public function downloadResultFile($id)
    {
        $labResult = LabResult::findOrFail($id);

        if (!$labResult->result_file) {
            abort(404);
        }

        $path = storage_path('app/public/' . $labResult->result_file);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->download($path);
    }
}





