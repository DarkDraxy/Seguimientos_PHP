<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $table = 'reservations';

    protected $fillable = ['name', 'service', 'service_name', 'date', 'slot', 'confirmed'];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'confirmed' => 'boolean',
        ];
    }
}
