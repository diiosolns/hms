<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    protected $table = 'prescriptions';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'patient_id',
        'medical_record_id',
        'pharmacy_items_id',
        'drug_name',
        'dosage',
        'frequency',
        'duration',
        'quantity',
        'dispensed_qty',
        'instructions',
        'status',
    ];

    /**
     * Relationship: Prescription belongs to a Patient
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Relationship: Prescription belongs to a MedicalRecord
     */
    public function medicalRecord()
    {
        return $this->belongsTo(MedicalRecord::class);
    }

    /**
     * Relationship: Prescription belongs to a PharmacyItem
     */
    public function pharmacyItem()
    {
        return $this->belongsTo(PharmacyItem::class, 'pharmacy_items_id');
    }
}
