<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SurveyOption extends Model
{
    protected $fillable = ['survey_id', 'text', 'votes'];

    public function survey(): BelongsTo
    {
        return $this->belongsTo(Survey::class);
    }
}
