<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailyServicePromotion extends Model
{
    protected $fillable = [
        'service_id',
        'date',
        'discount_percent',
    ];

    protected $casts = [
        'date' => 'date',
        'discount_percent' => 'integer',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function getDiscountedPriceAttribute(): float
    {
        return $this->service->discountedPrice($this->discount_percent);
    }

    public static function forToday(): ?self
    {
        return static::with('service')
            ->whereDate('date', today())
            ->first();
    }
}
