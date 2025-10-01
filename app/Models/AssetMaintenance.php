<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetMaintenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'maintenance_date',
        'performed_by',
        'details',
        'cost',
        'next_due_date',
    ];

    /**
     * Maintenance belongs to an asset.
     */
    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }
}
