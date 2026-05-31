<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Expense extends Model
{
    protected $table = 'expenses';

    protected $fillable = ['description', 'amount', 'category', 'date'];

    protected function casts(): array
    {
        return ['amount' => 'decimal:2', 'date' => 'date'];
    }


}


