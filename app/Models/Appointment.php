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
        'service_id',      
        'appointment_date',
        'appointment_time',
        'reason',
        'status',
        'hospital_id',  
        'branch_id', 
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'appointment_time' => 'datetime:H:i', // Laravel 10+ supports time casts
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
     * Appointment belongs to a service
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Appointment can have many nurse triage assessments
     */
    public function nurseTriageAssessments()
    {
        return $this->hasMany(NurseTriageAssessment::class);
    }

    /**
     * An appointment can have one medical record
     */
    public function medicalRecord()
    {
        return $this->hasOne(MedicalRecord::class);
    }

    /**
     * Optionally, appointment belongs to a hospital
     */
    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    /**
     * Optionally, appointment belongs to a branch
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
