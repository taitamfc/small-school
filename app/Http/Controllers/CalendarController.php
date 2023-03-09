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
        $start = $request->start ?? '';
        $end = $request->end ?? '';
        if($start && $end){
            $start = date('Y-m-d 00:00:00',strtotime($start));
            $end = date('Y-m-d 23:59:59',strtotime($end));
            $events = [];
            $items = Event::where('start_time', '>=', $start)
            ->where('start_time', '<=', $end)
            ->get();
            
            foreach( $items as $the_event ){
                global $events;
                $events[] = [
                    'arr' => [
                        'item'    => $the_event->toArray(),
                        'url'     => route('events.edit',$the_event->id),
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

            return response()->json($events);
        }
        return view('admin.calendars.index');
    }

    public function deleteEvent($event_id){
        try {
            $item = Event::where('id', '=',$event_id);
            $item->delete();
            return response()->json([
                'success' => true,
                'msg' => 'Xóa sự kiện thành công'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage()
            ]);
        }
    }
}
