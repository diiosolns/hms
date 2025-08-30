<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PharmacyItem extends Model
{
    use HasFactory;

    protected $table = 'pharmacy_items';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'hospital_id',
        'branch_id',
        'code',
        'name',
        'brand_name',
        'category',
        'form',
        'strength',
        'unit',
        'price',
        'reorder_level',
        'status',
        'expiry_date',
    ];

    /**
     * Relationship: PharmacyItem belongs to a Hospital
     */
    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    /**
     * Relationship: PharmacyItem belongs to a Branch
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * Relationship: PharmacyItem has many stock records
     */
    public function stock()
    {
        return $this->hasMany(PharmacyStock::class);
    }

    /**
     * Relationship: PharmacyItem has many prescriptions
     */
    public function prescriptions()
    {
        return $this->hasMany(Prescription::class, 'pharmacy_items_id');
    }
}
