<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Construction_Type extends Model
{
    use SoftDeletes;

    protected $table = "construction_types";
}
