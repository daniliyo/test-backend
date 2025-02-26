<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

trait ValidateCustomRequestTrait
{
    public function validateRequest($customRequest)
    {
        $validator = Validator::make($customRequest->all(), $customRequest->rules());

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}