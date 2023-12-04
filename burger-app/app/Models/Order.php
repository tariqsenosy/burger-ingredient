<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\OrderStatus;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'total', 'is_deleted', 'status_id'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_products', 'order_id', 'product_id')
            ->withPivot('quantity', 'unit_price', 'is_deleted')
            ->withTimestamps();
    }

    public function status()
    {
        return $this->belongsTo(OrderStatus::class);
    }
}
