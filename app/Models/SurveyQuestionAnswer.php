<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyQuestionAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'survey_id',
        'participant_id',
        'question_id',
        'selected_option_id',
        'input_answer',
        'remarks',
    ];

    public function survey_question()
    {
        return $this->belongsTo(ConfigSurveyQuestion::class, 'question_id');
    }
}
