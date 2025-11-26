<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    public function school() {
        return $this->belongsTo(School::class);
    }
    public function session() {
        return $this->belongsTo(Session::class, 'session_id');
    }

    public function campus() {
        return $this->belongsTo(Campus::class);
    }

    public function shift() {
        return $this->belongsTo(Shift::class);
    }

    public function class() {
        return $this->belongsTo(Classes::class);
    }

    public function section() {
        return $this->belongsTo(Section::class);
    }

    public function doctor() {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function schedule_details() {
        return $this->hasMany(ScheduleDetail::class);
    }
}
