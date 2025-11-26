<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassShift extends Model
{
    use HasFactory;

    public function class() {
        return $this->belongsTo(Classes::class);
    }

    public function shift() {
        return $this->belongsTo(Shift::class);
    }

    public function shifts() {
        return $this->belongsToMany(Shift::class, 'class_shifts', 'class_id', 'shift_id');
    }
}
