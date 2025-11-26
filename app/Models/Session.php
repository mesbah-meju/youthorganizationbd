<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\FuncCall;

class Session extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'name', 'school_id'
    ];

    public function school(){
        return $this->belongsTo(School::class, 'school_id');
    }

    public function class() {
        return $this->belongsTo(Classes::class);
    }
}
