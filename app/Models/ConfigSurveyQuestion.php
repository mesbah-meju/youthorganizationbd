<?php

namespace App\Models;

use App\Traits\EnumValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigSurveyQuestion extends Model
{
    use HasFactory, EnumValue;
    protected $fillable = ['section_id', 'question', 'type', 'status', 'order', 'is_parent'];
    public function section() {
        return $this->belongsTo(ConfigSurveySection::class, 'section_id');
    }

    public function options()
    {
        return $this->hasMany(ConfigSurveyQuestionOption::class, 'question_id');
    }
    
    public function conditional_questions()
    {
        return $this->hasMany(ConfigConditionalQuestion::class, 'parent_question_id');
    }

    public function conditionalQuestions()
    {
        return $this->hasMany(ConfigConditionalQuestion::class, 'parent_question_id', 'id')
            ->with('childQuestion');
    }
}
