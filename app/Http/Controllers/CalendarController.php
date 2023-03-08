<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Event;
use App\Http\Resources\EventCalendarResource;
class CalendarController extends Controller
{
    public $sources = [
        [
            'model'      =>  Event::class,
            'date_field' => 'start_time',
            'end_field'  => 'end_time',
            'field'      => 'name',
            'route'      => 'events.edit',
        ],
    ];

    public function index(Request $request)
    {
        $year = $request->year ?? date('Y');
        $month = $request->month ?? date('m');
        
        $events = [];
        $items = Event::whereYear('start_time', '=', $year)
        ->whereMonth('start_time', '=', $month)
        ->get();
        
        foreach( $items as $the_event ){
            global $events;
            $events[] = [
                'arr' => [
                    'item'    => $the_event->toArray(),
                    'teacher' => $the_event->teacher->name ?? $the_event->event->teacher->name,
                    'student' => $the_event->student->name ?? $the_event->event->student->name,
                    'start_format' => date('d/m/Y H:s', strtotime($the_event->start_time) ),
                    'end_format' => date('d/m/Y H:s', strtotime($the_event->end_time) )
                ],
                'id' => $the_event->id,
                'title' => $the_event->name,
                'start' => $the_event->start_time,
                'end' => $the_event->end_time

            ];
        }
        return view('admin.calendars.index', compact('events'));
    }
}
