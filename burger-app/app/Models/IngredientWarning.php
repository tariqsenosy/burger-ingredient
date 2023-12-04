<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ingredient;

class IngredientWarning extends Model
{
    use HasFactory;

    protected $fillable = ['ingredient_id', 'percentage', 'warning_sent', 'is_deleted'];

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class);
    }
}
