<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_code', 'name', 'category_id', 'quantity', 'unit',
        'purchase_price', 'selling_price', 'supplier_id',
        'storage_location', 'minimum_stock_level', 'description'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function stockHistories()
    {
        return $this->hasMany(StockHistory::class);
    }
}
