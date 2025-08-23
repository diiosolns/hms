<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NurseTriageAssessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'appointment_id',
        'nurse_id',
        'body_temperature',
        'blood_pressure_systolic',
        'blood_pressure_diastolic',
        'heart_rate',
        'respiratory_rate',
        'weight_kg',
        'height_cm',
        'chief_complaint',
        'notes',
    ];

    /**
     * Nurse Triage Assessment belongs to a patient
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Nurse Triage Assessment belongs to an appointment
     */
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    /**
     * Nurse Triage Assessment belongs to a nurse (user)
     */
    public function nurse()
    {
        return $this->belongsTo(User::class, 'nurse_id');
    }
}
