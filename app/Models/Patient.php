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
        'date_of_birth',
        'gender',
        'phone',
        'email',
        'address',
        'emergency_contact_name',
        'emergency_contact_contact',
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
}