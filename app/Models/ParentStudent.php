<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentStudent extends Model
{
    use HasFactory;

    
    public function school() {
        return $this->belongsTo(School::class, 'school_id');
    }

    public function class(){
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function section(){
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function campus()
    {
        return $this->belongsTo(Campus::class, 'campus_id');
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_id');
    }

    public function parent()
    {
        return $this->belongsTo(ParentStudent::class, 'parent_user_id');
    }
    public function children()
    {
        return $this->hasMany(ParentStudent::class, 'parent_user_id', 'user_id');
    }

    public function parentStudent()
    {
        return $this->hasOne(ParentStudent::class, 'student_user_id', 'user_id');
    }


    public function students()
    {
        return $this->hasManyThrough(Student::class, ParentStudent::class, 'parent_user_id', 'user_id', 'user_id', 'student_user_id');
    }


}
