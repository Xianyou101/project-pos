<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'is_cash',
    ];

    protected $casts = [
        'is_cash' => 'boolean',
    ];

    protected $appends = ['image_url'];

    /**
     * Relasi ke tabel orders
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Getter untuk image URL secara otomatis
     */
    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }

        // Gunakan storage path
        return asset('storage/' . ltrim($this->image, '/'));
    }
}
