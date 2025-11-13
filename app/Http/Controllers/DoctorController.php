<?php

namespace App\Http\Controllers;

use App\Models\LabResult;
use App\Models\DoctorNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
{
    /**
     * Show the doctor dashboard
     */
    public function dashboard()
    {
        $pendingResults = Auth::user()->doctorLabResults()->where('status', 'pending')->count();
        $reviewedResults = Auth::user()->doctorLabResults()->where('status', 'reviewed')->count();
        $myResults = Auth::user()->doctorLabResults()->with(['patient', 'labStaff'])->orderBy('created_at', 'desc')->get();
        
        return view('doctor.dashboard', compact('pendingResults', 'reviewedResults', 'myResults'));
    }

    /**
     * View all lab results assigned to this doctor
     */
    public function labResults()
    {
        $labResults = Auth::user()->doctorLabResults()->with(['patient', 'labStaff'])->get();
        return view('doctor.lab-results', compact('labResults'));
    }

    /**
     * View notes created by this doctor
     */
    public function notes(Request $request)
    {
        $query = \App\Models\DoctorNote::with(['labResult.patient'])
            ->where('doctor_id', Auth::id())
            ->orderBy('created_at', 'desc');

        if ($request->filled('q')) {
            $term = '%' . trim($request->q) . '%';
            $query->where(function ($q) use ($term) {
                $q->where('note', 'like', $term)
                  ->orWhereHas('labResult', function ($lr) use ($term) {
                      $lr->where('test_type', 'like', $term)
                        ->orWhere('result_value', 'like', $term)
                        ->orWhereHas('patient', function ($p) use ($term) {
                            $p->where('name', 'like', $term);
                        });
                  });
            });
        }

        $notes = $query->paginate(10)->appends($request->query());

        return view('doctor.notes', compact('notes'));
    }

    /**
     * View a specific lab result
     */
    public function viewLabResult($id)
    {
        $labResult = LabResult::with(['patient', 'labStaff', 'doctorNotes'])->findOrFail($id);
        
        // Check if the lab result is assigned to this doctor or if it's pending
        if ($labResult->doctor_id !== Auth::id() && $labResult->status === 'pending') {
            abort(403);
        }
        
        return view('doctor.view-lab-result', compact('labResult'));
    }

    /**
     * Download result file for a lab result assigned to this doctor
     */
    public function downloadResultFile($id)
    {
        $labResult = LabResult::findOrFail($id);
        if ($labResult->doctor_id !== Auth::id()) {
            abort(403);
        }
        if (!$labResult->result_file) {
            abort(404);
        }
        $path = storage_path('app/public/' . $labResult->result_file);
        if (!file_exists($path)) {
            abort(404);
        }
        return response()->download($path);
    }

    /**
     * Add a note to a lab result
     */
    public function addNote(Request $request, $id)
    {
        $request->validate([
            'note' => 'required|string',
        ]);

        $labResult = LabResult::findOrFail($id);

        // Create doctor note
        DoctorNote::create([
            'lab_result_id' => $labResult->id,
            'doctor_id' => Auth::id(),
            'note' => $request->note,
        ]);

        // Update the status to reviewed
        $labResult->update(['status' => 'reviewed']);

        // Create notification for patient
        \App\Models\Notification::create([
            'user_id' => $labResult->patient_id,
            'message' => 'Your lab result has been reviewed by a doctor',
        ]);

        \App\Models\ActivityLog::log(Auth::id(), 'Added doctor note to result ID: ' . (string) $labResult->id);
        return redirect()->back()->with('success', 'Note added successfully.');
    }

    /**
     * Update the status of a lab result
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,reviewed,completed',
        ]);

        $labResult = LabResult::findOrFail($id);

        // Check if this doctor is assigned to the lab result
        if ($labResult->doctor_id !== Auth::id()) {
            abort(403);
        }

        $labResult->update(['status' => $request->status]);

        // Create notification for patient
        \App\Models\Notification::create([
            'user_id' => $labResult->patient_id,
            'message' => 'Your lab result status has been updated to: ' . $request->status,
        ]);

        \App\Models\ActivityLog::log(Auth::id(), 'Updated result status ID: ' . (string) $labResult->id . ' to ' . (string) $request->status);
        return redirect()->back()->with('success', 'Status updated successfully.');
    }
}

