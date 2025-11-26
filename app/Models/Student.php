<?php

namespace App\Models;

use App\Traits\EnumValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory, EnumValue; 

    protected $fillable = [
        'name',
        'dob',
        'age',
        'sex',
        'school_id',
        'class_id',
        'section_id',
        'roll',
        'home_address',
        'parent_user_type',
        'parent_user_id',
        'father_name',
        'father_age',
        'father_profession',
        'father_email',
        'father_contact_no',
        'mother_name',
        'mother_age',
        'mother_profession',
        'mother_email',
        'mother_contact_no',
        'ecp_name',
        'ecp_relationship',
        'ecp_email',
        'ecp_contact_no',
        'family_income_range',
    ];

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
