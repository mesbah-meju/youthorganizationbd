<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationBank extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'organization_id',
        'bank_name',
        'branch_name',
        'account_name',
        'account_number',
    ];
}
