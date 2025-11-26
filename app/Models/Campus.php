<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campus extends Model
{
    use HasFactory;

    public function school() {
        return $this->belongsTo(School::class);
    }

    public function shifts() {
        return $this->hasMany(Shift::class);
    }

    public function coordinators() {
        return $this->hasMany(Coordinator::class);
    }
}
