<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name',
        'description',
        'duration',
        'price',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function discountedPrice(int $discountPercent): float
    {
        return round((float) $this->price * (1 - $discountPercent / 100), 2);
    }
}