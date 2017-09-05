<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AbsenceEvent extends Model
{
    protected $table = "absence";
    public $primaryKey = "event_id";
    public $timestamps = false;
}
