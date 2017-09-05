<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;

class PersonalController extends Controller
{
    public function getReport() {

    	$currentYear = date('Y');
    	$numberOfDaysInYear = date("z", mktime(0,0,0,12,31,$currentYear)) + 1;
    	$holidays = \App\Holiday::where('year', $currentYear)->first();
    	$numberOfHolidays = $holidays->required_days + $holidays->extra_days;

    	$hoursWorked = \App\TaskTimer::where('user_id', Auth::user()->id)
    								 ->where(DB::raw('YEAR(date)'), $currentYear)
    								 ->sum('hours');

    	$minWorked = \App\TaskTimer::where('user_id', Auth::user()->id)
    							   ->where(DB::raw('YEAR(date)'), $currentYear)
    							   ->sum('minutes');

  		$numberOfPlannedHours = ($numberOfDaysInYear - $numberOfHolidays) * 8;
  		$numberOfExecutedHours = $hoursWorked + ceil($minWorked/60);

  		return view('personalReport', array('numberOfPlannedHours' => $numberOfPlannedHours, 'numberOfExecutedHours' => $numberOfExecutedHours));
    }

    public function getReportFromYear(Request $r) {
    	$year = $r['year'];
    	$numberOfDaysInYear = date("z", mktime(0,0,0,12,31,$year)) + 1;
    	$holidays = \App\Holiday::where('year', $year)->first();
    	if($holidays != null)
			$numberOfHolidays = $holidays->required_days + $holidays->extra_days;
		else
			$numberOfHolidays = 0;

    	$hoursWorked = \App\TaskTimer::where('user_id', Auth::user()->id)
    								 ->where(DB::raw('YEAR(date)'), $year)
    								 ->sum('hours');

    	$minWorked = \App\TaskTimer::where('user_id', Auth::user()->id)
    							   ->where(DB::raw('YEAR(date)'), $year)
    							   ->sum('minutes');

  		$numberOfPlannedHours = ($numberOfDaysInYear - $numberOfHolidays) * 8;
  		$numberOfExecutedHours = $hoursWorked + ceil($minWorked/60);

  		return array($numberOfExecutedHours, $numberOfPlannedHours);
    }
}
