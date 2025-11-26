<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigSurveySection extends Model
{
    use HasFactory;

    protected $fillable = ['section_name', 'status', 'order'];

    /**
     * Relationship with ConfigSurveyQuestion
     */
    public function questions()
    {
        return $this->hasMany(ConfigSurveyQuestion::class, 'section_id', 'id');
    }
}
