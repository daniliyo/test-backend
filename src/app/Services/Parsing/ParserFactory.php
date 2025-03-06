<?php

namespace App\Services\Parsing;

use App\Services\Parsing\Contract\ParserContract;
use App\Services\Parsing\Parsers\CbrParser;

class ParserFactory
{
    static public function create(string $type): ParserContract
    {
        return match($type) {
            'cbr' => new CbrParser(),
            default => throw new \Exception("Unknown parser type"),
        };
    } 
}