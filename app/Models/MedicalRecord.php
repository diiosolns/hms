<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $table = 'medical_records';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'visit_date',
        'chief_complaint',
        'diagnosis',
        'treatment_plan',
        'notes',
        'status',
    ];

    /**
     * Relationship: MedicalRecord belongs to a Patient
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Relationship: MedicalRecord belongs to a Doctor (User)
     */
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    /**
     * Relationship: MedicalRecord has many Prescriptions
     */
    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }
}
