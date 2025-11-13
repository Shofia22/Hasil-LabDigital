<?php

namespace App\Http\Controllers;

use App\Models\LabResult;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PatientController extends Controller
{
    /**
     * Show the patient dashboard
     */
    public function dashboard()
    {
        $labResults = Auth::user()->patientLabResults()->with(['doctor', 'labStaff'])->orderBy('created_at', 'desc')->get();
        $totalResults = $labResults->count();
        $completedResults = $labResults->where('status', 'completed')->count();
        $unreadNotifications = Auth::user()->notifications()->unread()->count();
        
        return view('patient.dashboard', compact('labResults', 'totalResults', 'completedResults', 'unreadNotifications'));
    }

    /**
     * View all lab results for the patient
     */
    public function labResults(Request $request)
    {
        $query = Auth::user()->patientLabResults()
            ->with(['doctor', 'labStaff'])
            ->orderBy('created_at', 'desc');

        if ($request->filled('status') && in_array($request->status, ['pending', 'reviewed', 'completed'])) {
            $query->where('status', $request->status);
        }

        if ($request->filled('q')) {
            $term = '%' . trim($request->q) . '%';
            $query->where(function ($q) use ($term) {
                $q->where('test_type', 'like', $term)
                  ->orWhere('result_value', 'like', $term)
                  ->orWhereHas('doctor', function ($dq) use ($term) {
                      $dq->where('name', 'like', $term);
                  });
            });
        }

        $perPage = 9;
        $labResults = $query->paginate($perPage)->appends($request->query());

        return view('patient.lab-results', compact('labResults'));
    }

    /**
     * View a specific lab result
     */
    public function viewLabResult($id)
    {
        $labResult = Auth::user()->patientLabResults()->with(['doctor', 'labStaff', 'doctorNotes'])->findOrFail($id);
        
        return view('patient.view-lab-result', compact('labResult'));
    }

    /**
     * Download lab result file
     */
    public function downloadResultFile($id)
    {
        $labResult = Auth::user()->patientLabResults()->findOrFail($id);

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
     * Download lab result as PDF
     */
    public function downloadResultPdf($id)
    {
        $labResult = Auth::user()->patientLabResults()
            ->with(['doctor', 'labStaff', 'patient', 'doctorNotes'])
            ->findOrFail($id);

        $html = view('pdf.lab-result', compact('labResult'))->render();

        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4');
        $dompdf->render();

        return response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="lab-result-' . $labResult->id . '.pdf"'
        ]);
    }

    /**
     * View patient profile
     */
    public function profile()
    {
        $user = Auth::user();
        return view('patient.profile', compact('user'));
    }

    /**
     * Update patient profile
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
        ]);

        $user = Auth::user();
        $user->update($request->only(['name', 'email']));

        return redirect()->route('patient.profile')->with('success', 'Profile updated successfully.');
    }

    /**
     * View notifications
     */
    public function notifications()
    {
        $notifications = Auth::user()->notifications()->orderBy('created_at', 'desc')->get();
        
        // Mark all as read
        foreach ($notifications as $notification) {
            $notification->markAsRead();
        }
        
        return view('patient.notifications', compact('notifications'));
    }

    /**
     * Get unread notification count
     */
    public function getUnreadNotificationsCount()
    {
        return response()->json([
            'count' => Auth::user()->notifications()->unread()->count()
        ]);
    }
}
