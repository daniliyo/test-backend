<?php

namespace App\Services\Parsing\Parsers;

use Illuminate\Support\Facades\Http;
use App\Services\Parsing\Contract\ParserContract;
use App\Exceptions\ParsingException;

abstract class BaseParser implements ParserContract 
{
    public function __construct(protected string $url) { }

    public function fetchData(): string
    {
        try {
            $url = static::getUrl();
            
            $response = Http::get($this->url);

            if(!$response->successful()){
                throw new ParsingException('Request error: server returned  '.$response->status());
            }

            return $response->body();
        } catch(\Throwable $e){
            throw new ParsingException("Resource unavailable", 0, $e);
        }
    }
}