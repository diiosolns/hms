<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class LabRequest extends Model
{
    use HasFactory;

    protected $table = 'lab_requests';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'hospital_id',
        'branch_id',
        'patient_id',
        'requested_by',
        'status',
        'requested_at',
    ];

    /**
     * Relationship: LabRequest belongs to a Hospital
     */
    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    /**
     * Relationship: LabRequest belongs to a Branch
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * Relationship: LabRequest belongs to a Patient
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Relationship: LabRequest belongs to a User (Doctor/Nurse who requested)
     */
    public function requester()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    /**
     * Relationship: LabRequest has many LabRequestTests
     */
    public function requestTests()
    {
        return $this->hasMany(LabRequestTest::class);
    }
}
