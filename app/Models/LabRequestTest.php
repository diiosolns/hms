<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabRequestTest extends Model
{
    use HasFactory;

    protected $table = 'lab_request_tests';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'lab_request_id',
        'lab_test_id',
        'status',
        'result',
        'unit',
        'reference_range',
        'performed_by',
        'completed_at',
        'attachment',
    ];

    /**
     * Relationship: LabRequestTest belongs to a LabRequest
     */
    public function labRequest()
    {
        return $this->belongsTo(LabRequest::class);
    }

    /**
     * Relationship: LabRequestTest belongs to a LabTest
     */
    public function labTest()
    {
        return $this->belongsTo(LabTest::class);
    }

    /**
     * Relationship: LabRequestTest belongs to a User (Lab Tech who performed it)
     */
    public function performedBy()
    {
        return $this->belongsTo(User::class, 'performed_by');
    }
}
