<?php

namespace App\Services\Parsing\Parsers;

use Symfony\Component\DomCrawler\Crawler;
use App\Exceptions\ParsingException;

class CbrParser extends BaseParser
{
    public function __construct()
    {
        parent::__construct("https://www.cbr.ru/scripts/XML_daily.asp");
    }
    
    public function parse(string $data): array
    {
        try {
            $crawler = new Crawler($data);
            $date = $crawler->attr('Date');

            return $crawler->filter('Valute')->each(function(Crawler $node) use ($date) {
                return [
                    'num_code' => $node->filter('NumCode')->text(),
                    'char_code' => $node->filter('CharCode')->text(),
                    'name' => $node->filter('Name')->text(),
                    'nominal' => $node->filter('Nominal')->text(),
                    'value' => (float) str_replace(",", ".", $node->filter('Value')->text()),
                    'vunit_rate' => (float) str_replace(",", ".", $node->filter('VunitRate')->text()),
                    'date' => $date,
                ];
            });
        } catch(\Throwable $e){
            throw new ParsingException($e->getMessage(), 0, $e);
        }

    }
}