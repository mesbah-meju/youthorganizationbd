<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleDetail extends Model
{
    use HasFactory;

    public function schedule() {
        return $this->belongsTo(Schedule::class);
    }

    public function student() {
        return $this->belongsTo(Student::class, 'student_id', 'user_id');
    }
    public function sesssion() {
        return $this->belongsTo(Session::class);
    }
    public function school() {
        return $this->belongsTo(School::class, 'school_id');
    }
    
}
