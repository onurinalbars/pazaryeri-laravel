<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'logo',
        'description',
        'is_active',
        'pos_provider',
        'pos_merchant_id',
        'pos_api_key',
        'pos_secret_key',
        'pos_extra_config',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'pos_extra_config' => 'array',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function listings()
    {
        return $this->hasMany(Listing::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
