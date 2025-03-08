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
        try {
            \Log::info('Запуск SaveParsedDataJob', $this->data);
            $currencyService->createCurrency($this->data);
            \Log::info('Успешно выполнена');
        } catch (\Throwable $e) {
            \Log::info('Ошибка выполнения', ['message' => $e->getMessage()]);
        }
    }
}
