<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profiles extends Model
{
    protected $fillable = [
        'id',
        'user_id',
        'name',
        'address',
        'phone',
        'created_at',
        'updated_at'
    ];
}
