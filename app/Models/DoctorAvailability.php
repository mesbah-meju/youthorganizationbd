<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorAvailability extends Model
{
    use HasFactory;

    protected $fillable = ['doctor_id', 'date','start_time','end_time'];
    
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function school() {
        return $this->belongsTo(School::class, 'school_id');
    }
}
