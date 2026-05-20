<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'client_id',
        'service_id',
        'service_combo_id',
        'master_id',
        'appointment_date',
        'status',
        'discount_percent',
    ];

    protected $casts = [
        'appointment_date' => 'datetime',
        'discount_percent' => 'integer',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function serviceCombo()
    {
        return $this->belongsTo(ServiceCombo::class);
    }

    public function hasDiscount(): bool
    {
        return $this->discount_percent !== null && $this->discount_percent > 0;
    }

    public function getFinalPriceAttribute(): float
    {
        $price = (float) $this->service->price;

        if ($this->hasDiscount()) {
            return round($price * (1 - $this->discount_percent / 100), 2);
        }

        return $price;
    }

    public function getPromotionLabelAttribute(): ?string
    {
        if ($this->service_combo_id) {
            return 'Комбо';
        }

        if ($this->hasDiscount()) {
            return 'Услуга дня';
        }

        return null;
    }

    public function master()
    {
        return $this->belongsTo(User::class, 'master_id');
    }
}