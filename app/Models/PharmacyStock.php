<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PharmacyStock extends Model
{
    use HasFactory;

    protected $table = 'pharmacy_stock';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'hospital_id',
        'branch_id',
        'pharmacy_item_id',
        'type',
        'quantity',
        'balance',
        'batch_no',
        'expiry_date',
        'reference',
        'user_id',
    ];

    /**
     * Relationship: Stock entry belongs to a Hospital
     */
    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    /**
     * Relationship: Stock entry belongs to a Branch
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * Relationship: Stock entry belongs to a PharmacyItem
     */
    public function pharmacyItem()
    {
        return $this->belongsTo(PharmacyItem::class);
    }

    /**
     * Relationship: Stock entry belongs to a User (who performed the transaction)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
