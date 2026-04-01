<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['user_id', 'name', 'price', 'stock'];

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tag');
    }
}