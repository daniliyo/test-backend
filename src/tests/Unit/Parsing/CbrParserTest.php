<?php

namespace Tests\Unit\Parsing;

use PHPUnit\Framework\TestCase;
use App\Services\Parsing\Parsers\CbrParser;
use App\Exceptions\ParsingException;

class CbrParserTest extends TestCase
{
    public function test_parse_valid_data()
    {
        $xml = <<<XML
            <ValCurs Date="08.03.2025" name="Foreign Currency Market">
                <Valute ID="R01010">
                    <NumCode>036</NumCode>
                    <CharCode>AUD</CharCode>
                    <Nominal>1</Nominal>
                    <Name>Австралийский доллар</Name>
                    <Value>56,2093</Value>
                    <VunitRate>56,2093</VunitRate>
                </Valute>
                <Valute ID="R01020A">
                    <NumCode>944</NumCode>
                    <CharCode>AZN</CharCode>
                    <Nominal>1</Nominal>
                    <Name>Азербайджанский манат</Name>
                    <Value>52,4331</Value>
                    <VunitRate>52,4331</VunitRate>
                </Valute>
            </ValCurs>
        XML;

        $parser = new CbrParser();
        $result = $parser->parse($xml);

        $this->assertCount(2, $result);
        $this->assertNotNull($result[0]['name']);
        $this->assertEquals('036', $result[0]['num_code']);
    }

    public function test_parse_empty_data()
    {
        $emptyData = <<<XML
            <ValCurs Date="08.03.2025" name="Foreign Currency Market">
            </ValCurs>
        XML;

        $parser = new CbrParser();
        $result = $parser->parse($emptyData);

        $this->assertEmpty($result);
    }

    public function test_parse_empty_xml_file()
    {
        $this->expectException(ParsingException::class);

        $xml = "";

        $parser = new CbrParser();
        $result = $parser->parse($xml);

    }
}
