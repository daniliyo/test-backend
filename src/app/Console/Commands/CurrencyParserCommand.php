<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Services\Parsing\ParserFactory;
use App\Services\Parsing\ParsingService;

class CurrencyParserCommand extends Command
{
    public function __construct(protected ParsingService $parsingService){
        parent::__construct();
    }
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:start-currency-parsing-daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ежедневный парсинг валют';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $data = $this->parsingService->parse('cbr');
        $this->parsingService->addDataToJobs($data);
    }
}
