<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationAward extends Model
{
    use HasFactory;

    protected $table = 'organization_awards';

    protected $fillable = [
        'user_id',
        'organization_id',
        'type',
        'award_tittle',
        'from_organization',
        'recieve_date',
    ];
}
