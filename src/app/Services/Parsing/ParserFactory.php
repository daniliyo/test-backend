<?php

namespace App\Services\Parsing;

use App\Services\Parsing\Contract\ParserContract;
use App\Services\Parsing\Parsers\CbrParser;

class ParserFactory
{
    public function create(string $type): ParserContract
    {
        return match($type) {
            'cbr' => app()->make(CbrParser::class),
            default => throw new \Exception("Unknown parser type"),
        };
    } 
}