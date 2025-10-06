<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $fillable = [
        'hospital_id',
        'branch_id',
        'priceable_id',
        'priceable_type',
        'insurance_company_id',
        'price',
    ];

    public function priceable()
    {
        return $this->morphTo();
    }

    public function insuranceCompany()
    {
        return $this->belongsTo(InsuranceCompany::class);
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
