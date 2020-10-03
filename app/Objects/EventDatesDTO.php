<?php

namespace App\Objects;

use Spatie\DataTransferObject\DataTransferObject;
use Illuminate\Http\Request;

class EventDatesDTO extends DataTransferObject
{

    public $dateFrom;
    public $dateTo;
    public $days;
    public $eventName;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'dateFrom' => $request->input('date_from'),
            'dateTo' => $request->input('date_to'),
            'days' => $request->input('days'),
            'eventName' => $request->input('event_name'),
        ]);
    }
}
