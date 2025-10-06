<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $fillable = [
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
}
