<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

use App\Services\CurrencyService;

class SaveParsedDataJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected array $data, 
    )
    {
        
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $currencyService = new CurrencyService();
        $currencyService->createCurrency($this->data);
    }
}
