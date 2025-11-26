<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationGrant extends Model
{
    use HasFactory;

    protected $table = 'organization_grants';

    protected $fillable = [
        'user_id',
        'organization_id',
        'grant_detail',
        'from_organization',
        'recieve_date',
    ];
}
