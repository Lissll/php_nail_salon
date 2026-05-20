<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceCombo extends Model
{
    protected $fillable = [
        'name',
        'service_id_1',
        'service_id_2',
        'discount_percent',
    ];

    protected $casts = [
        'discount_percent' => 'integer',
    ];

    public function service1(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id_1');
    }

    public function service2(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id_2');
    }

    public function getOriginalTotalAttribute(): float
    {
        return (float) $this->service1->price + (float) $this->service2->price;
    }

    public function getDiscountedTotalAttribute(): float
    {
        return round($this->original_total * (1 - $this->discount_percent / 100), 2);
    }
}
