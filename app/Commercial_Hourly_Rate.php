<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Commercial_Hourly_Rate extends Model
{
    use SoftDeletes;
    protected $table = 'commercial_hourly_rate';
}
