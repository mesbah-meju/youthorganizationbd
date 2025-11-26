<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'user_id',
        'designation',
        'is_founder',
        'name_bn',
        'name_en',
        'dob',
        'age',
        'nid',
        'address',
        'phone',
        'email',
        'image',
    ];
}
