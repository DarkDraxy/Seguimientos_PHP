<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';
    protected $fillable = ['title', 'date', 'time', 'description', 'reminder'];
    protected $casts = [
        'date' => 'date',
        'reminder' => 'boolean',
    ];
}
