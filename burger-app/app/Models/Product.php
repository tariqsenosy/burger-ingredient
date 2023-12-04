<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ingredient;
use App\Models\Order;


class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'is_deleted'];

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'product_ingredients', 'product_id', 'ingredient_id')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_products', 'product_id', 'order_id')
            ->withPivot('quantity', 'unit_price', 'is_deleted')
            ->withTimestamps();
    }
}
