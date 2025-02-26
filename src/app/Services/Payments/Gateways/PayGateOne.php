<?php

namespace App\Services\Payments\Gateways;

use Carbon\Carbon;
use App\Services\Payments\PaymentGatewayAbstract;
use Illuminate\Http\Request;
use App\Http\Requests\Payments\PayGateOne\CallbackRequest;
use App\Traits\ValidateCustomRequestTrait;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Services\Redis\DailyLimitService;

class PayGateOne extends PaymentGatewayAbstract
{
    use ValidateCustomRequestTrait;

    public function validRequest(Request $request)
    {
        $this->validateRequest(CallbackRequest::createFrom($request));
    }

    public function validateCallback(Request $request)
    {
        $hashOriginal = $request->input('sign');
        $hashCalc = $this->calcHash($request->all());
        
        if($hashOriginal !== $hashCalc) {
            throw new HttpException(422, "Invalid hash");
        }

        $payment = $this->insertPayment($request);

        DailyLimitService::setexDailyLimit(__class__, $this->getTodayPayments());

        return response()->json($payment, 201);
    }

    public function calcHash(array $request): string
    {
        $fieldsArr = collect($request)->except(['sign'])->sortkeys()->all();

        $line = implode(':', $fieldsArr).env('PAYMENT_GITEWAY_ONE_MERCHANT_KEY');
        
        return hash('sha256', $line);
    }

    public function getDailyLimit(): float
    {
        return env('PAYMENT_GITEWAY_ONE_DAILY_LIMIT');
    }
       
}