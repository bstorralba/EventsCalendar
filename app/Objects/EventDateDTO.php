<?php

namespace App\Objects;

use Spatie\DataTransferObject\DataTransferObject;
use Illuminate\Http\Request;

class EventDateDTO extends DataTransferObject
{

	public $date;
	public $dateName;
	public $eventName;


}