<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'price',
        'stock',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock'  => 'integer',
    ];

    // Relasi: Product belongs to User (Many-to-One)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}