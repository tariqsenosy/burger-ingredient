<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\IngredientWarning;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'stock', 'is_deleted'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_ingredients', 'ingredient_id', 'product_id')
            ->withPivot('quantity', 'is_deleted')
            ->withTimestamps();
    }

    public function warnings()
    {
        return $this->hasMany(IngredientWarning::class);
    }
}
