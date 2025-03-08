<?php

namespace App\Services\Parsing;

use App\Services\Parsing\Contract\ParserContract;
use App\Jobs\SaveParsedDataJob;
use App\Exceptions\ParsingException;

class ParsingService
{
    public function __construct(protected ParserFactory $factory) {}

    public function parse(string $type): array
    {

        try {
            $parser = $this->factory->create($type);
            
            $data = $parser->fetchData();
            $parsedData = $parser->parse($data);

            if(!$parsedData) {
                \Log::info("Массив пустой - возможно на искомом ресурсе произошли изменения");
            }

            return $parsedData;
        } catch (ParsingException $e) {
            throw new ParsingException($e->getMessage());
        }
    }

    public function addDataToJobs($data): void
    {
        foreach($data as $item){
            SaveParsedDataJob::dispatch($item);
        }
    }
}