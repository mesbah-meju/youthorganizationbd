<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'last_meeting_date',
        'total_members_last_meeting',
        'members_opinion_doc',
        'plan',
        'plan_doc',
        'objectives',
        'objectives_doc',
    ];
}
