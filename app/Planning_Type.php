<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Planning_Type extends Model
{
    use SoftDeletes;

    protected $table = 'planning_types';
}
