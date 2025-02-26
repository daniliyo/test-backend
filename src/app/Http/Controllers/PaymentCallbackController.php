<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Payments\Gateways\PayGateOne;
use App\Services\Payments\Gateways\PayGateTwo;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Services\Redis\DailyLimitService;

class PaymentCallbackController extends Controller
{
    protected $dailyLimitService;

    public function __construct(DailyLimitService $dailyLimitService) {
        
        $this->dailyLimitService = $dailyLimitService;
    }
    
    public function callback(Request $request)
    {
        if($request->header('Content-Type') === 'application/json'){
            $paymentGateway = new PayGateOne($request);
        } else if(strpos($request->header('Content-Type'), 'multipart/form-data') === 0){
            $paymentGateway = new PayGateTwo($request);
        } else {
            throw new HttpException(400, "Unsupported payment gateway");
        }

        $paymentGateway->validRequest($request);

        $amount_paid = $request->input('amount_paid');
        $canPay = $this->dailyLimitService->canProcessPayment($paymentGateway, $amount_paid);

        if(!$canPay) 
        {
            throw new HttpException(400, "Daily limit exceeded");
        }

        return $paymentGateway->validateCallback($request);
        
        //return 123;
    }

}
