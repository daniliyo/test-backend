<?php

namespace App\Enums\Statuses;

enum PayGateTwoEnum: string
{
    case created = 'created';
    case inprogress = 'inprogress';
    case completed = 'completed';
    case paid = 'paid';
    case expired = 'expired';
    case rejected = 'rejected';
}