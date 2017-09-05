<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GanttTask extends Model
{
	use SoftDeletes;
	
    protected $table = "gantt_tasks";
    public $primaryKey = "id";
    public $timestamps = false;
}