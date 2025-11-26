<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigFcm extends Model
{
    use HasFactory;

    protected $table = 'config_fcm';
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
