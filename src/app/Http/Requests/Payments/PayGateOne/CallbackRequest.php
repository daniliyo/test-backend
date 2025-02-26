<?php

namespace App\Http\Requests\Payments\PayGateOne;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Enums\Statuses\PayGateOneEnum;

class CallbackRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'merchant_id' => 'required|integer',
            'payment_id' => 'required|integer',
            'status' => [Rule::enum(PayGateOneEnum::class)],
            'amount' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'amount_paid' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'timestamp' => 'required|integer',
            'sign' => 'required|string',
        ];
    }
}
