<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Executed_Task extends Model
{
    use SoftDeletes;

    protected $table = "executed_tasks";
}
