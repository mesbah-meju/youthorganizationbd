<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'division_id',
        'district_id',
        'upazila_id',
        'post_office_bn',
        'post_office_en',
        'street_bn',
        'street_en',
        'address_bn',
        'address_en',
        'website',
        'facebook',
        'linkedin',
        'twitter',
        'phone',
        'email',
    ];
}
