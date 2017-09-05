<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company_Day extends Model
{
    use SoftDeletes;

    protected $table = "company_days";
}
