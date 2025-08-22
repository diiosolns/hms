<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'branch_id',
        'hospital_id',
        'first_name',
        'last_name',
        'email',
        'password',
        'role',
        'phone',
        'address',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Hash the user's password automatically.
     *
     * @param  string  $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    //------------------------------------------------------------------------------------------------------------------
    // RELATIONSHIPS
    //------------------------------------------------------------------------------------------------------------------

    /**
     * Get the hospitals for the user.
     * A user belongs to a single hospital.
     */
    public function hospital(): BelongsTo
    {
        return $this->belongsTo(Hospital::class, 'hospital_id');
    }

    /**
     * Get the branch for the user.
     * A user belongs to a single branch.
     *
     * @return BelongsTo
     */
    public function branch(): BelongsTo
    {
        return $this->belongsTo(HospitalBranch::class, 'branch_id');
    }

    /**
     * Get the hospitals for the user (as an owner).
     */
    public function hospitals(): HasMany
    {
        return $this->hasMany(Hospital::class, 'owner_id');
    }

    /**
     * Define the relationship for Appointments.
     * A user (doctor) can have many appointments.
     *
     * @return HasMany
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }

    /**
     * Define the relationship for Medical Records.
     * A user (doctor) can have many medical records.
     *
     * @return HasMany
     */
    public function medicalRecords(): HasMany
    {
        return $this->hasMany(MedicalRecord::class, 'doctor_id');
    }

    /**
     * Define the relationship for Lab Tests.
     * A user (doctor or technician) can be related to many lab tests.
     *
     * @return HasMany
     */
    public function labTests(): HasMany
    {
        return $this->hasMany(LabTest::class, 'ordering_doctor_id');
    }

    public function performedLabTests(): HasMany
    {
        return $this->hasMany(LabTest::class, 'technician_id');
    }
}
