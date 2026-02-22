<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Maintenance extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'vehicle_id',
        'kilometraje',
        'prox_kilometraje',
        'fecha',
        'total_cost',
        'observaciones',
    ];

    protected $casts = [
        'fecha' => 'datetime',
        'total_cost' => 'decimal:2',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function parts()
    {
        return $this->belongsToMany(Part::class, 'maintenance_part')
            ->withPivot('quantity', 'price_at_time')
            ->withTimestamps();
    }

    public function labors()
    {
        return $this->belongsToMany(Labor::class, 'maintenance_labor')
            ->withPivot('cost_at_time')
            ->withTimestamps();
    }
}
