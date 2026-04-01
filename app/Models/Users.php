<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = ['password'];
    public function profiles()
    {
        return $this->hasOne(Profiles::class, 'user_id');
    }
}
