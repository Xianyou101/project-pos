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

    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'stock',
        'price',
        'is_active',
        'image',
        'barcode',
        'description',
    ];

    protected $appends = ['image_url'];

    /**
     * Relasi ke kategori.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Generate slug unik untuk produk.
     */
    public static function generateUniqueSlug(string $name): string
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        while (self::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }

        return $slug;
    }

    /**
     * Getter URL gambar produk.
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? url('storage/' . $this->image) : null;
    }

    /**
     * Scope pencarian produk berdasarkan nama.
     */
    public function scopeSearch($query, $value)
    {
        return $query->where('name', 'like', "%{$value}%");
    }

    /**
     * Relasi ke order-product.
     */
    public function orderProducts(): HasMany
    {
        return $this->hasMany(OrderProduct::class);
    }
}
