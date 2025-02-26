<?php

namespace App\Services\Payments;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\Payments\PayGateOne\CallbackRequest;
use Illuminate\Support\Facades\Validator;
use App\Models\Payment;
use Exception;

abstract class PaymentGatewayAbstract 
{

    abstract public function validRequest(Request $request);

    abstract public function validateCallback(Request $request);

    abstract public function calcHash(array $request): string;

    abstract public function getDailyLimit(): float;

    public function getTodayPayments(): float
    {
        return Payment::where('gateway', static::class)->whereDate('created_at', '=', Carbon::today())->sum('amount_paid');
    }

    public function insertPayment(Request $request)
    {
        try {
            $paymentData = $request->merge(['gateway' => static::class])->all();
            $payment = Payment::create($paymentData);
            return $payment;
        } catch(Exception $e) {
            throw new Exception();
        }

    }
}