<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'brand',
        'model',
        'year',
        'plate',
        'kilometraje',
    ];

    protected $casts = [
        'kilometraje' => 'integer',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function maintenances()
    {
        return $this->hasMany(Maintenance::class);
    }
}
