<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HospitalBranch extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'address',
        'parent_hospital_id',
    ];

    /**
     * Define the inverse relationship to a parent hospital.
     * A branch can belong to a parent hospital.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parentHospital()
    {
        return $this->belongsTo(HospitalBranch::class, 'parent_hospital_id');
    }

    /**
     * Define the relationship to its child branches.
     * A hospital can have many branches.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function branches()
    {
        return $this->hasMany(HospitalBranch::class, 'parent_hospital_id');
    }
}
