<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schoolusers extends Model
{
    use HasFactory;
    public $table = 'school_users_relations';
    protected $fillable = [
        'school_id',
        'user_id',
        'role_id',
    ];
}
