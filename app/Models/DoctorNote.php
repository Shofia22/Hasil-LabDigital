<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DoctorNote extends Model
{
    protected $fillable = [
        'lab_result_id',
        'doctor_id',
        'note',
    ];

    protected $casts = [
        'lab_result_id' => 'integer',
        'doctor_id' => 'integer',
    ];

    /**
     * Get the lab result that this note belongs to
     */
    public function labResult(): BelongsTo
    {
        return $this->belongsTo(LabResult::class);
    }

    /**
     * Get the doctor who created this note
     */
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}
