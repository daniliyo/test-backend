<?php

namespace App\Http\Requests\Payments\PayGateTwo;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use App\Enums\Statuses\PayGateTwoEnum;
use Illuminate\Validation\Rule;

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
            'project' => 'required|integer',
            'invoice' => 'required|integer',
            'status' => [Rule::enum(PayGateTwoEnum::class)],
            'amount' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'amount_paid' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'rand' => 'required|string',
        ];
    }
}
