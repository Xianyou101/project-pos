<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_number', 'customer_id', 'date',
        'payment_method', 'total_amount', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
