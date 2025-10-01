<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'hospital_id',
        'branch_id',
        'category_id',
        'assigned_to',
        'name',
        'description',
        'serial_number',
        'purchase_date',
        'purchase_cost',
        'status',
        'location',
        'warranty_expiry',
    ];

    /**
     * Asset belongs to a category.
     */
    public function category()
    {
        return $this->belongsTo(AssetCategory::class, 'category_id');
    }

    /**
     * Asset belongs to a hospital.
     */
    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    /**
     * Asset belongs to a branch.
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * Asset may be assigned to a user.
     */
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Asset has many maintenance records.
     */
    public function maintenances()
    {
        return $this->hasMany(AssetMaintenance::class, 'asset_id');
    }
}
