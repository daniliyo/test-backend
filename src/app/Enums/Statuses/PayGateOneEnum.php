<?php

namespace App\Enums\Statuses;

enum PayGateOneEnum: string
{
    case new = 'new';
    case pending = 'pending';
    case completed = 'completed';
    case expired = 'expired';
    case rejected = 'rejected';
}