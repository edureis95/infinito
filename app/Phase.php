<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Phase extends Model
{
	use SoftDeletes;
    protected $table = "phases";
}
