<?php

namespace App\Services;

use App\Models\Currency;

class CurrencyService 
{
    public function createCurrency(array $data)
    {
        return Currency::updateOrCreate($data);
    }
}