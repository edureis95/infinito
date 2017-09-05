<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Utilization_Type extends Model
{
    use SoftDeletes;

    protected $table = "utilization_types";
}
