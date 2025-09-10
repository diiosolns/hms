<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;

    protected $table = 'invoice_items';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'invoice_id',
        'description',
        'type',
        'quantity',
        'unit_price',
        'total',
    ];

    /**
     * Relationship: InvoiceItem belongs to an Invoice
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
