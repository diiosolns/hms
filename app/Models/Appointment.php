<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_date',
        'appointment_time',
        'reason',
        'status',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'appointment_time' => 'datetime:H:i', // optional, Laravel 10+ supports time casts
    ];

    /**
     * Appointment belongs to a patient
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Appointment belongs to a doctor (user)
     */
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    /**
     * Appointment can have many nurse triage assessments
     */
    public function nurseTriageAssessments()
    {
        return $this->hasMany(NurseTriageAssessment::class);
    }

     /**
     * Define the relationship for Medical Records.
     * An appointment can have one medical record.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function medicalRecord()
    {
        return $this->hasOne(MedicalRecord::class);
    }
}
