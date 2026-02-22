<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Labor extends Model
{
    use SoftDeletes;

    // Eliminamos $table = 'labor' para que use el default 'labors'
    // ya que la migración creó la tabla 'labors'.

    protected $fillable = [
        'name',
        'description',
        'standard_price',
    ];

    public function maintenance()
    {
        return $this->belongsToMany(Maintenance::class)
            ->withPivot('cost_at_time')
            ->withTimestamps();
    }
}