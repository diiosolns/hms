<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoices';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'patient_id',
        'user_id',
        'invoice_number',
        'invoice_date',
        'total_amount',
        'status',
    ];

    /**
     * Cast attributes to appropriate data types.
     */
    protected $casts = [
        'invoice_date' => 'date',
        'total_amount' => 'decimal:2',
    ];

    /**
     * Relationship: Invoice belongs to a Patient
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Relationship: Invoice belongs to a User (receptionist who created it)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Optionally, you can define a relationship to invoice items if needed
     */
    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
