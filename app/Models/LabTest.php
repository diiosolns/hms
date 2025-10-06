<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabTest extends Model
{
    use HasFactory;

    protected $table = 'lab_tests';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'hospital_id',
        'branch_id',
        'code',
        'name',
        'category',
        'description',
        'sample_type',
        'method',
        'normal_range',
        'unit',
        'price',
        'status',
    ];

    /**
     * Relationship: LabTest belongs to a Hospital
     */
    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    /**
     * Relationship: LabTest belongs to a Branch
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * Relationship: LabTest has many LabRequestTests
     */
    public function labRequestTests()
    {
        return $this->hasMany(LabRequestTest::class);
    }

    public function prices()
    {
        return $this->morphMany(Price::class, 'priceable');
    }

    public function getPriceForInsurance($insuranceId = null)
    {
        return $this->prices()
            ->where('insurance_company_id', $insuranceId)
            ->value('price')
            ?? $this->prices()->whereNull('insurance_company_id')->value('price');
    }

}
