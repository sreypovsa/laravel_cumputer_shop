<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'original_price' => 'decimal:2',
        'price' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_new' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name) . '-' . Str::random(5);
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getImageUrlAttribute(): string
    {
        if (empty($this->image)) {
            return asset('nevixra_assets/images/product-img-1.png');
        }
        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }
        if (file_exists(public_path('storage/' . $this->image))) {
            return asset('storage/' . $this->image);
        }
        if (file_exists(public_path($this->image))) {
            return asset($this->image);
        }
        // Fallback for cccomputerkh relative image paths
        return 'https://cccomputerkh.com/' . ltrim($this->image, '/');
    }

    public function getDiscountPercentAttribute(): ?int
    {
        if ($this->original_price && $this->original_price > $this->price) {
            return round((($this->original_price - $this->price) / $this->original_price) * 100);
        }
        return null;
    }

    public function getSpecsListAttribute(): array
    {
        if (empty($this->specs)) return [];
        $lines = explode("\n", str_replace(["\r\n", "\r"], "\n", $this->specs));
        return array_values(array_filter(array_map('trim', $lines)));
    }
}
