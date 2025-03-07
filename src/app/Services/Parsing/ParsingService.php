<?php

namespace App\Services\Parsing;

use App\Services\Parsing\Contract\ParserContract;
use App\Jobs\SaveParsedDataJob;

class ParsingService
{
    public function __construct(protected ParserFactory $factory) {}

    public function parse(string $type)
    {
        $parser = $this->factory->create($type);
        
        $data = $parser->fetchData();
        $parsedData = $parser->parse($data);

        foreach($parsedData as $item){
            SaveParsedDataJob::dispatch($item);
        }
    }
}