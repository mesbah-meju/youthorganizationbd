<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationDomain extends Model
{
    use HasFactory;

    protected $table = 'organization_domain_of_works';
    protected $fillable = [
        'user_id',
        'organization_id',
        'domain_id',
        'others',
    ];
}
