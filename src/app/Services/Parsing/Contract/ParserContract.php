<?php

namespace App\Services\Parsing\Contract;

interface ParserContract
{
    public function fetchData(): string;

    public function parse(string $data): array;
}