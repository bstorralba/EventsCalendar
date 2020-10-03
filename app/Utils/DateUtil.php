<?php

namespace App\Utils;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Objects\EventDateDTO;

class DateUtil{

	public function __construct(){}

	public static function getDatesOfCurrMonth(){
		$now = Carbon::now();

		$firstDay = Carbon::parse($now)->firstOfMonth()->toDateString();
		$lastDay = Carbon::parse($now)->endOfMonth()->toDateString();

		$period = CarbonPeriod::create($firstDay, $lastDay);

		$datesFormatted = array();
		foreach($period as $date){
			$dateName = $date->day . " " . $date->format('D');

			$eventDate = new EventDateDTO();
			$eventDate->dateName = $dateName;
			$eventDate->eventDate = $date->format('Y-m-d');
			
			array_push($datesFormatted, $eventDate);
		}
		return $datesFormatted;
	}

}