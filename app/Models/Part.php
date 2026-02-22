<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Part extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'brand',
        'description',
        'manages_stock',
        'current_price',
        'stock',
        'min_stock',
    ];

    protected $casts = [
        'manages_stock' => 'boolean',
        'current_price' => 'decimal:2',
    ];

    public function maintenance()
    {
        return $this->belongsToMany(Maintenance::class, 'maintenance_part')
            ->withPivot('quantity', 'price_at_time')
            ->withTimestamps();
    }
}
