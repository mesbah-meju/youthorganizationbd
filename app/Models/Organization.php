<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $table = 'organizations';

    protected $fillable = [
        'user_id',
        'reg_type',
        'work_area',
        'org_name_bn',
        'org_name_en',
        'org_type',
        'old_reg_type',
        'reg_no',
        'established_date',
        'logo',
    ];

    public function user() 
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function address()
    {
        return $this->hasOne(OrganizationAddress::class, 'user_id', 'user_id');
    }

    public function rejectdBy() 
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }

    public function approvedBy() 
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}

