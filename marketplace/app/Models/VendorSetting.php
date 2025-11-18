<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'pos_api_key',
        'pos_api_secret',
        'pos_merchant_id',
        'pos_terminal_id',
        'pos_environment',
        'extra_payload',
    ];

    protected $casts = [
        'extra_payload' => 'array',
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
