<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LabResult extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'lab_staff_id',
        'test_type',
        'result_value',
        'status',
        'result_file',
    ];

    protected $casts = [
        'patient_id' => 'integer',
        'doctor_id' => 'integer',
        'lab_staff_id' => 'integer',
        'status' => 'string',
    ];

    /**
     * Get the patient that owns the lab result
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    /**
     * Get the doctor who reviewed the lab result
     */
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    /**
     * Get the lab staff who created the lab result
     */
    public function labStaff(): BelongsTo
    {
        return $this->belongsTo(User::class, 'lab_staff_id');
    }

    /**
     * Get the doctor notes for this lab result
     */
    public function doctorNotes(): HasMany
    {
        return $this->hasMany(DoctorNote::class);
    }

    /**
     * Get the most recent doctor note for this lab result
     */
    public function getLatestNoteAttribute()
    {
        return $this->doctorNotes()->latest()->first();
    }

    /**
     * Scope to get results by status
     */
    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to get results by patient
     */
    public function scopeByPatient($query, int $patientId)
    {
        return $query->where('patient_id', $patientId);
    }

    /**
     * Scope to get results by lab staff
     */
    public function scopeByLabStaff($query, int $labStaffId)
    {
        return $query->where('lab_staff_id', $labStaffId);
    }

    /**
     * Scope to get results by doctor
     */
    public function scopeByDoctor($query, int $doctorId)
    {
        return $query->where('doctor_id', $doctorId);
    }
}
