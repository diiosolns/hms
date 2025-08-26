<?php

// app/Models/Patient.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
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
     * Define the relationship for Appointments.
     * A patient can have many appointments.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * A patient can have many nurse triage assessments.
     */
    public function nurseTriageAssessments()
    {
        return $this->hasMany(NurseTriageAssessment::class);
    }

    /**
     * Define the relationship for Medical Records.
     * A patient can have many medical records.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }

    /**
     * Define the relationship for Lab Tests.
     * A patient can have many lab tests.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function labTests()
    {
        return $this->hasMany(LabTest::class);
    }

    /**
     * Define the relationship for prescription.
     * A patient can have many prescription.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function prescription()
    {
        return $this->hasMany(Prescription::class);
    }

    /**
     * Define the relationship with Branch.
     * A patient belongs to a branch.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * Define the relationship with Hospital.
     * A patient belongs to a hospital.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    /**
     * Define the relationship with Users.
     * doctor_id → the foreign key on the patients table.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }


}