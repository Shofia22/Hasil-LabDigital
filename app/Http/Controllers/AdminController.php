<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\LabResult;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard
     */
    public function dashboard()
    {
        $totalUsers = User::count();
        $doctorCount = User::where('role', 'doctor')->where('status', 'active')->count();
        $patientCount = User::where('role', 'patient')->where('status', 'active')->count();
        $labStaffCount = User::where('role', 'lab')->where('status', 'active')->count();
        $totalResults = LabResult::count();
        $completedResults = LabResult::where('status', 'completed')->count();
        $pendingResults = LabResult::whereIn('status', ['pending', 'reviewed'])->count();
        $recentActivity = ActivityLog::latest()->take(10)->get();
        $users = User::orderBy('name')->take(10)->get();

        return view('admin.dashboard', compact('totalUsers', 'doctorCount', 'patientCount', 'labStaffCount', 'totalResults', 'completedResults', 'pendingResults', 'recentActivity', 'users'));
    }

    /**
     * Doctors management page
     */
    public function doctors()
    {
        $users = User::where('role', 'doctor')->orderBy('name')->get();
        return view('admin.doctors', compact('users'));
    }

    /**
     * Patients management page
     */
    public function patients()
    {
        $users = User::where('role', 'patient')->orderBy('name')->get();
        return view('admin.patients', compact('users'));
    }

    /**
     * Lab staff management page
     */
    public function labStaff()
    {
        $users = User::where('role', 'lab')->orderBy('name')->get();
        return view('admin.lab-staff', compact('users'));
    }

    /**
     * System report page
     */
    public function reports()
    {
        $totalResults = LabResult::count();
        $completed = LabResult::where('status', 'completed')->count();
        $inProcess = LabResult::whereIn('status', ['pending', 'reviewed'])->count();
        $doctorCount = User::where('role', 'doctor')->count();
        $patientCount = User::where('role', 'patient')->count();
        $labStaffCount = User::where('role', 'lab')->count();
        $recentActivity = ActivityLog::latest()->take(10)->get();

        return view('admin.reports', compact('totalResults', 'completed', 'inProcess', 'doctorCount', 'patientCount', 'labStaffCount', 'recentActivity'));
    }

    /**
     * Show the user management page
     */
    public function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    /**
     * Show create user form
     */
    public function createUser()
    {
        return view('admin.create-user');
    }

    /**
     * Store a new user
     */
    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,doctor,lab,patient',
            'status' => 'required|in:active,inactive',
        ]);

        $newUser = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => $request->status,
        ]);
        // Log activity and redirect to dashboard so counters reflect the change immediately
        \App\Models\ActivityLog::log(auth()->id(), 'Created user: ' . $newUser->name . ' (' . $newUser->role . ')');

        return redirect()->route('admin.dashboard')->with('success', 'User created successfully.');
    }

    /**
     * Edit a user
     */
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit-user', compact('user'));
    }

    /**
     * Update user
     */
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,doctor,lab,patient',
            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->only(['name', 'email', 'role', 'status']);
        
        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        \App\Models\ActivityLog::log(auth()->id(), 'Updated user: ' . $user->name . ' (' . $user->role . ')');

        return redirect()->route('admin.users')->with('success', 'User updated successfully.');
    }

    /**
     * Delete a user
     */
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $deletedName = $user->name;
        $user->delete();
        \App\Models\ActivityLog::log(auth()->id(), 'Deleted user: ' . $deletedName);

        return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
    }

    /**
     * View all lab results
     */
    public function labResults()
    {
        $labResults = LabResult::with(['patient', 'doctor', 'labStaff'])->get();
        return view('admin.lab-results', compact('labResults'));
    }

    /**
     * View a specific lab result (admin)
     */
    public function viewLabResult($id)
    {
        $labResult = LabResult::with(['patient', 'doctor', 'labStaff', 'doctorNotes'])->findOrFail($id);
        return view('admin.view-lab-result', compact('labResult'));
    }
}
