<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationDocument extends Model
{
    use HasFactory;
    
    protected $table = 'organization_documents';

    protected $fillable = [
        'user_id',
        'organization_id',
        'challan',
        'reg_doc',
        'constitution',
        'general_members',
        'council_members',
    ];
}
