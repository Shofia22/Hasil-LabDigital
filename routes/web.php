<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\LabController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// Default dashboard route - will redirect based on user role
Route::get('/dashboard', function () {
    $user = auth()->user();
    
    if ($user) {
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isDoctor()) {
            return redirect()->route('doctor.dashboard');
        } elseif ($user->isLab()) {
            return redirect()->route('lab.dashboard');
        } elseif ($user->isPatient()) {
            return redirect()->route('patient.dashboard');
        }
    }
    
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    // Segmented user management
    Route::get('/doctors', [AdminController::class, 'doctors'])->name('doctors');
    Route::get('/patients', [AdminController::class, 'patients'])->name('patients');
    Route::get('/lab-staff', [AdminController::class, 'labStaff'])->name('lab-staff');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('create-user');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('store-user');
    Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('edit-user');
    Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('update-user');
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('delete-user');
    Route::get('/lab-results', [AdminController::class, 'labResults'])->name('lab-results');
    Route::get('/lab-results/{id}', [AdminController::class, 'viewLabResult'])->name('view-lab-result');
    // System reports
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
});

// Doctor routes
Route::middleware(['auth', 'doctor'])->prefix('doctor')->name('doctor.')->group(function () {
    Route::get('/dashboard', [DoctorController::class, 'dashboard'])->name('dashboard');
    Route::get('/lab-results', [DoctorController::class, 'labResults'])->name('lab-results');
    Route::get('/lab-results/{id}', [DoctorController::class, 'viewLabResult'])->name('view-lab-result');
    Route::get('/lab-results/{id}/download', [DoctorController::class, 'downloadResultFile'])->name('download-result-file');
    Route::post('/lab-results/{id}/note', [DoctorController::class, 'addNote'])->name('add-note');
    Route::put('/lab-results/{id}/status', [DoctorController::class, 'updateStatus'])->name('update-status');
    Route::get('/notes', [DoctorController::class, 'notes'])->name('notes');
});

// Lab Staff routes
Route::middleware(['auth', 'lab'])->prefix('lab')->name('lab.')->group(function () {
    Route::get('/dashboard', [LabController::class, 'dashboard'])->name('dashboard');
    Route::get('/lab-results', [LabController::class, 'labResults'])->name('lab-results');
    Route::get('/lab-results/create', [LabController::class, 'createLabResult'])->name('create-lab-result');
    Route::post('/lab-results', [LabController::class, 'storeLabResult'])->name('store-lab-result');
    Route::get('/lab-results/{id}', [LabController::class, 'viewLabResult'])->name('view-lab-result')->whereNumber('id');
    Route::get('/lab-results/{id}/edit', [LabController::class, 'editLabResult'])->name('edit-lab-result')->whereNumber('id');
    Route::put('/lab-results/{id}', [LabController::class, 'updateLabResult'])->name('update-lab-result')->whereNumber('id');
    Route::delete('/lab-results/{id}', [LabController::class, 'deleteLabResult'])->name('delete-lab-result')->whereNumber('id');
    Route::get('/lab-results/{id}/download', [LabController::class, 'downloadResultFile'])->name('download-result-file')->whereNumber('id');
});

// Patient routes
Route::middleware(['auth', 'patient'])->prefix('patient')->name('patient.')->group(function () {
    Route::get('/dashboard', [PatientController::class, 'dashboard'])->name('dashboard');
    Route::get('/lab-results', [PatientController::class, 'labResults'])->name('lab-results');
    Route::get('/lab-results/{id}', [PatientController::class, 'viewLabResult'])->name('view-lab-result');
    Route::get('/lab-results/{id}/download', [PatientController::class, 'downloadResultFile'])->name('download-result-file');
    Route::get('/lab-results/{id}/pdf', [PatientController::class, 'downloadResultPdf'])->name('download-result-pdf');
    Route::get('/profile', [PatientController::class, 'profile'])->name('profile');
    Route::put('/profile', [PatientController::class, 'updateProfile'])->name('update-profile');
    Route::get('/notifications', [PatientController::class, 'notifications'])->name('notifications');
});

// General notification routes
Route::middleware(['auth'])->prefix('notifications')->name('notifications.')->group(function () {
    Route::get('/', [NotificationController::class, 'index'])->name('index');
    Route::post('/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('mark-as-read');
    Route::post('/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('mark-all-as-read');
    Route::get('/unread-count', [NotificationController::class, 'getUnreadCount'])->name('unread-count');
});

// Profile routes (available to all authenticated users)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Optional: logout via GET fallback to avoid 405 when JS prevents POST form submission
Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth')->name('logout.get');
