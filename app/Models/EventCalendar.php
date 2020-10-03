<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Objects\EventDatesDTO;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class EventCalendar extends Model
{
    // use HasFactory;

    protected $fillable = ['event_date', 'event_name'];
    public $primaryKey = 'event_date';
    protected $casts = [
        'event_date' => 'string',
    ];


}
