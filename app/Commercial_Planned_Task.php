<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Commercial_Planned_Task extends Model
{
    use SoftDeletes;
    protected $table = 'commercial_planned_tasks';
}
