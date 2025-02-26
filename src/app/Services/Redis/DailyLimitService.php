<?php

namespace App\Services\Redis;

use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Services\Payments\PaymentGatewayAbstract;
use Illuminate\Support\Facades\Redis;
use Carbon\Carbon;

class DailyLimitService 
{
    protected $gatewayPrefix = 'gateway:';

    public function canProcessPayment(PaymentGatewayAbstract $paymentGateway, float|int $amount_paid)
    {
        $key = $this->gatewayPrefix.get_class($paymentGateway);

        $currentLimit = (float) Redis::get($key) ?? $paymentGateway->getTodayPayments();

        $maxLimit = $paymentGateway->getDailyLimit();

        if ($currentLimit + $amount_paid > $maxLimit) {
            return false;
        }

        return true; 
    }

    static public function setexDailyLimit(string $paymentGatewayClass, $todayAmount)
    {
        $secondsToMidnight = (int)Carbon::now()->diffInSeconds(Carbon::now()->endOfDay());
        $key = 'gateway:'.$paymentGatewayClass;
        Redis::setex($key, $secondsToMidnight, $todayAmount);
    }
}