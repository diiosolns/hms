<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'hospital_id',
        'branch_id',
        'code',
        'name',
        'category',
        'fee',
        'status',
    ];

    /**
     * Relationship: Service belongs to a Hospital
     */
    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    /**
     * Relationship: Service belongs to a Branch
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * Relationship: Service has many Appointments
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * Scope: Only active services
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'Active');
    }

    /**
     * Accessor: Display service code with name
     */
    public function getDisplayNameAttribute()
    {
        return "{$this->code} - {$this->name}";
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
