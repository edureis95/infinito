<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Absence_Reason extends Model
{
	use SoftDeletes;
    protected $table = "absence_reasons";
}
