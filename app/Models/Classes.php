<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'name', 'school_id'
    ];

    public function school(){
        return $this->belongsTo(School::class, 'school_id');
    }

    public function campus(){
        return $this->belongsTo(Campus::class, 'campus_id');
    }

    public function sections(){
        return $this->hasMany(Section::class, 'class_id');
    }

    public function classShifts() {
        return $this->hasMany(ClassShift::class, 'class_id');
    }
}
