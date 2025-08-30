<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'hospital_id',
        'branch_id',
        'first_name',
        'last_name',
        'patient_id',
        'doctor_id',
        'date_of_birth',
        'gender',
        'phone',
        'email',
        'address',
        'emergency_contact_name',
        'emergency_contact_phone',
        'pay_method',
        'status',
    ];

    /**
     * A patient can have many appointments.
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * A patient can have many invoices.
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * A patient can have many pending invoices.
     */
    public function pendingInvoices()
    {
        return $this->hasMany(Invoice::class)->where('status', 'Pending');
    }

    /**
     * A patient can have many nurse triage assessments.
     */
    public function nurseTriageAssessments()
    {
        return $this->hasMany(NurseTriageAssessment::class);
    }

    /**
     * A patient can have many medical records.
     */
    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }

    /**
     * A patient can have many lab requests.
     */
    public function labRequests()
    {
        return $this->hasMany(LabRequest::class);
    }

    /**
     * A patient can have many prescriptions.
     */
    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    /**
     * A patient belongs to a branch.
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * A patient belongs to a hospital.
     */
    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    /**
     * A patient is assigned to a doctor (user).
     */
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}
