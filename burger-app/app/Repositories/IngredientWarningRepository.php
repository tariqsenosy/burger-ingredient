<?php
// app/Repositories/IngredientWarningRepository.php

namespace App\Repositories;

use App\Models\Ingredient;
use App\Models\IngredientWarning;

class IngredientWarningRepository
{
    public function getWarningByIngredientAndPercentage(Ingredient $ingredient, $percentage)
    {
        return IngredientWarning::where('ingredient_id', $ingredient->id)
            ->where('percentage', '>=', $percentage)
            ->where('warning_sent', false)
            ->first();
    }

    public function markWarningAsSent(IngredientWarning $warning)
    {
        $warning->update(['warning_sent' => true]);
    }
}
