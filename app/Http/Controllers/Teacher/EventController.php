<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index(Request $request)
    {
        return view('teachers.events.index');
    }
    public function calendar(Request $request)
    {
        $start = $request->start ?? '';
        $end = $request->end ?? '';
        $teacher_id = Auth::guard('teachers')->user()->id;
        if($start && $end && $teacher_id){
            $start = date('Y-m-d 00:00:00',strtotime($start));
            $end = date('Y-m-d 23:59:59',strtotime($end));
            $events = [];
            $items = Event::where('start_time', '>=', $start)
            ->where('start_time', '<=', $end)
            ->where('teacher_id',$teacher_id)
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
        return view('teachers.events.calendar');
    }
}
