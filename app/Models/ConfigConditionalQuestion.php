<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigConditionalQuestion extends Model
{
    use HasFactory;

    public function question()
    {
        return $this->hasMany(ConfigSurveyQuestion::class, 'child_question_id');
    }

    public function parent_question()
    {
        return $this->belongsTo(ConfigSurveyQuestion::class, 'parent_question_id');
    }

    public function child_question()
    {
        return $this->belongsTo(ConfigSurveyQuestion::class, 'child_question_id');
    }

    public function child_question_options()
    {
        return $this->hasMany(ConfigSurveyQuestionOption::class, 'question_id');
    }

    public function trigger_option()
    {
        return $this->belongsTo(ConfigSurveyQuestionOption::class, 'trigger_option_id');
    }

    public function childQuestion()
    {
        return $this->belongsTo(ConfigSurveyQuestion::class, 'child_question_id', 'id');
    }
}
