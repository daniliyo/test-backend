<?php

namespace App\Services\Parsing\Parsers;

use Illuminate\Support\Facades\Http;
use App\Services\Parsing\Contract\ParserContract;

abstract class BaseParser implements ParserContract 
{
    public function fetchData(): string
    {
        $url = static::getUrl();
        
        return Http::get($url)->body();
    }
}