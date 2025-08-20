<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hospital extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'address',
        'contact_number',
        'owner_id',
    ];

    /**
     * Get the owner that owns the hospital.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class);
    }

    /**
     * Get the branches for the hospital.
     */
    public function branches(): HasMany
    {
        return $this->hasMany(Branch::class);
    }

    /**
     * Get the employees for the hospital.
     */
    public function employees(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the patients for the hospital.
     */
    public function patients(): HasMany
    {
        return $this->hasMany(Patient::class);
    }
}
