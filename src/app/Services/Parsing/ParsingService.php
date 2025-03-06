<?php

namespace App\Services\Parsing;

use App\Services\Parsing\Contract\ParserContract;
use App\Jobs\SaveParsedDataJob;

class ParsingService
{
    public function __construct(protected ParserContract $parser) {}

    public function parse()
    {
        $data = $this->parser->fetchData();
        
        $parsedData = $this->parser->parse($data);

        foreach($parsedData as $item){
            SaveParsedDataJob::dispatch($item);
        }
    }
}