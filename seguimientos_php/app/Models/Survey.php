<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Survey extends Model
{
    protected $fillable = ['title', 'question', 'responses'];

    public function options(): HasMany
    {
        return $this->hasMany(SurveyOption::class);
    }
}
