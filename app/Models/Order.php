<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'shipping_fee' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'total' => 'decimal:2',
        'confirmed_at' => 'datetime',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getPaymentMethodNameAttribute(): string
    {
        return match($this->payment_method) {
            'aba_khqr' => 'ABA PAY (KHQR)',
            'acleda_khqr' => 'ACLEDA KHQR',
            'wing_khqr' => 'Wing Bank QR',
            'cod' => 'Cash On Delivery (COD)',
            default => strtoupper($this->payment_method),
        };
    }

    public function getOrderStatusBadgeAttribute(): string
    {
        return match($this->order_status) {
            'pending' => '<span class="badge bg-warning text-dark"><i class="ti ti-clock"></i> Pending</span>',
            'confirmed' => '<span class="badge bg-info"><i class="ti ti-check"></i> Confirmed</span>',
            'processing' => '<span class="badge bg-primary"><i class="ti ti-package"></i> Processing</span>',
            'shipping' => '<span class="badge bg-secondary"><i class="ti ti-truck-delivery"></i> Shipping</span>',
            'delivered' => '<span class="badge bg-success"><i class="ti ti-circle-check"></i> Delivered</span>',
            'cancelled' => '<span class="badge bg-danger"><i class="ti ti-x"></i> Cancelled</span>',
            default => '<span class="badge bg-light text-dark">' . ucfirst($this->order_status) . '</span>',
        };
    }

    public function getPaymentStatusBadgeAttribute(): string
    {
        return match($this->payment_status) {
            'paid' => '<span class="badge bg-success"><i class="ti ti-check"></i> Paid</span>',
            'pending' => '<span class="badge bg-warning text-dark"><i class="ti ti-clock"></i> Pending Payment</span>',
            'rejected' => '<span class="badge bg-danger"><i class="ti ti-x"></i> Rejected</span>',
            default => '<span class="badge bg-secondary">' . ucfirst($this->payment_status) . '</span>',
        };
    }

    public function getTrackingStepAttribute(): int
    {
        return match($this->order_status) {
            'pending' => 1,
            'confirmed' => 2,
            'processing' => 3,
            'shipping' => 4,
            'delivered' => 5,
            'cancelled' => 0,
            default => 1,
        };
    }

    public function getPaymentSlipUrlAttribute(): ?string
    {
        if (empty($this->payment_slip)) return null;
        return asset('storage/' . $this->payment_slip);
    }
}
