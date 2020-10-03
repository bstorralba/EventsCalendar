<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventCalendar;
use App\Service\EventCalendarService;
use App\Objects\EventDatesDTO;

class EventCalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $eventCalendars = EventCalendar::all()->toArray();
        return array_reverse($eventCalendars);
    }

    /**
     * Get all events for the current month
     *
     * @return \Illuminate\Http\Response
     */
    
    public function getEventsOfCurrMonth()
    {
        $eventList = EventCalendarService::getEventsOfCurrMonth();

        return response()->json($eventList);
    }

    /**
     * Store all seleted dates
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addEventDates(Request $request)
    {

        $eventDatesDTO = EventDatesDTO::fromRequest($request);
        $dateList = EventCalendarService::mapEventCalendar($eventDatesDTO);

        return response()->json("Event calendar successfully updated");
    }
}
