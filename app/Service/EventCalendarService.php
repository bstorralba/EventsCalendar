<?php

namespace App\Service;

use App\Objects\EventDatesDTO;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\EventCalendar;
use App\Utils\DateUtil;

class EventCalendarService
{
	public function __construct(){}

	public static function mapEventCalendar(EventDatesDTO $dto){

    	$period = CarbonPeriod::create($dto->dateFrom, $dto->dateTo);

		/* format all dates for database transaction */
    	$datesFormatted = array();
		foreach($period as $date){
			array_push($datesFormatted, $date->format('Y-m-d'));
		}

		$dates = $period->toArray();

		/* convert selected days to date */
		$dateList = array();
		foreach ($dates as $date){
			$isDaySelected = in_array($date->format('l'), $dto->days);
			if($isDaySelected){
				array_push($dateList, $date->format('Y-m-d'));
			}
		}

		static::deleteAllFromRange($datesFormatted);
		static::writeEvents($dateList, $dto->eventName);

		return $dateList;
    }

    public static function getEventsOfCurrMonth(){

         $datesCurrMonth = DateUtil::getDatesOfCurrMonth();
         $now = Carbon::now();
         $res = EventCalendar::whereMonth('event_date', $now->month)->get();  

         if($res){
            foreach($res as $data){
                foreach($datesCurrMonth as $date){
                    if($date->eventDate == $data->event_date){
                        $date->eventName = $data->event_name;
                    }
                }
            }
         }  

         return $datesCurrMonth;	
    }

    public static function writeEvents($dateList, $eventName){
    	foreach($dateList as $date){
    		$eventCalendar = new EventCalendar([
	            'event_date' => $date,
	            'event_name' => $eventName
        	]);

        	$eventCalendar->save();
    	}
    }

    public static function deleteAllFromRange($datesFormatted){
    	foreach($datesFormatted as $date){
    		static::deleteEvent($date);
    	}
    }

    public static function deleteEvent($date){
    	$eventCalendar = EventCalendar::find($date);
    	if($eventCalendar != null && !empty($eventCalendar)){
    		$eventCalendar->delete();
    	}
    }

}