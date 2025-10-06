<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InsuranceCompany extends Model
{
    protected $fillable = [
        'hospital_id',
        'branch_id',
        'name',
        'contact_person',
        'phone',
        'email',
        'address',
        'status',
    ];
    

    public function prices()
    {
        return $this->hasMany(Price::class);
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
}

