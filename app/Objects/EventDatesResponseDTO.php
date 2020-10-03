<?php

namespace App\Objects;

use Spatie\DataTransferObject\DataTransferObject;
use Illuminate\Http\Request;

class EventDatesResponseDTO extends DataTransferObject
{

	public $list;

	public class EventDate{
		public $date;
		public $dateText;
		public $eventName;
	}

}