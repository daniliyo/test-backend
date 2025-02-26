<?php

namespace App\Services\Payments\Gateways;

use App\Services\Payments\PaymentGatewayAbstract;
use Illuminate\Http\Request;
use App\Http\Requests\Payments\PayGateTwo\CallbackRequest;
use App\Traits\ValidateCustomRequestTrait;
use App\Services\Redis\DailyLimitService;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PayGateTwo extends PaymentGatewayAbstract
{
    use ValidateCustomRequestTrait;

    public function validRequest(Request $request)
    {
        $this->validateRequest(CallbackRequest::createFrom($request));
    }

    public function validateCallback(Request $request)
    {
        $hashOriginal = $request->header('Authorization');
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
        $fieldsArr = collect($request)->sortkeys()->all();

        $line = implode('.', $fieldsArr).env('PAYMENT_GITEWAY_TWO_APP_KEY');
        
        return hash('MD5', $line);
    }

    public function getDailyLimit(): float
    {
        return env('PAYMENT_GITEWAY_TWO_DAILY_LIMIT');
    }
}