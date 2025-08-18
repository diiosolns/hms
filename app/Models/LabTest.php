<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabTest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'patient_id',
        'ordering_doctor_id',
        'test_name',
        'order_date',
        'status',
        'results_text',
        'results_file_path',
        'technician_id',
        'completed_at',
    ];

    /**
     * Define the inverse relationship to Patient.
     * A lab test belongs to one patient.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Define the inverse relationship to User (Ordering Doctor).
     * A lab test belongs to one ordering doctor.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function orderingDoctor()
    {
        return $this->belongsTo(User::class, 'ordering_doctor_id');
    }

    /**
     * Define the inverse relationship to User (Technician).
     * A lab test can belong to one technician.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }
}
