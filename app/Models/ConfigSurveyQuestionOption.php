<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigSurveyQuestionOption extends Model
{
    use HasFactory;

    public function survey_question()
    {
        return $this->belongsTo(ConfigSurveyQuestion::class, 'question_id');
    }
    
}
