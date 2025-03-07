<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

use App\Services\CurrencyService;

class SaveParsedDataJob implements ShouldQueue
{
    use Queueable;

    public function __construct(protected array $data) { }

    public function handle(CurrencyService $currencyService): void
    {
        $currencyService->createCurrency($this->data);
    }
}
