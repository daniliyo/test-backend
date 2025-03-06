<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable = [
        'num_code',
        'char_code',
        'name',
        'nominal',
        'value',
        'vunit_rate',
        'date',
    ];

}
