<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Product;
use App\Models\User;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'cart';

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'total_price',
    ];

    // ✅ RELASI KE PRODUCT (INILAH YANG HILANG)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // ✅ RELASI KE USER
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
