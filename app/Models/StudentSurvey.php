<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentSurvey extends Model
{
    use HasFactory; 

    protected $fillable = [
        'survey_id',
        'student_id',
        'screening_date',
        'remarks',
        'status',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function survey()
    {
        return $this->belongsTo(User::class, 'survey_id');
    }
}
