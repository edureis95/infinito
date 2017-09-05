<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class State_Type extends Model
{
	use SoftDeletes;
	protected $table = 'state_types';
}
