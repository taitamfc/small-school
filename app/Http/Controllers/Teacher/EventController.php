<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use App\Models\Event;

class EventController extends Controller
{
    public function show ($id)
    {
        $event = Event::find($id);
        // Nếu ko có danh sách học viên riêng thì lấy danh sách cha
        if( !count($event->students) ){
            $event->students = $event->event->students;
        }
        return view('teachers.events.show', compact('event'));
    }
    public function update ($id, Request $request)
    {
        $item = Event::find($id);
        $data = $request->except(['_token','_method']);
        // Cập nhật cho sự kiện này và sự kiện trở về sau
        try {
            // Cập nhật cho sự kiện hiện tại
            $item->update($data);
            return redirect()->route('teachers.events.show',$id)->with('success', 'Cập nhật thành công !');
        } catch (\Exception $e) {
            Log::error('message: ' . $e->getMessage() . ' line: ' . $e->getLine() . ' file: ' . $e->getFile());
            return redirect()->route('teachers.events.show',$id)->with('error', 'Cập nhật không thành công !');
        }
    }
    public function index(Request $request)
    {
        $teacher_id = Auth::guard('teachers')->user()->id;
        $status = new Event();
        $query = Event::query(true);
        $query->where('teacher_id',  $teacher_id);

        //Search
        //End Search

        $query->orderBy('id','DESC');
        $items = $query->paginate(10);
        $params = [
            'items'       => $items,
            'status'     => $status,
        ];
        return view('teachers.events.index',$params);
    }
    public function histories(Request $request)
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
                        'url'     => route('teachers.events.show',$the_event->id),
                        'teacher' => $the_event->teacher->name ?? $the_event->event->teacher->name,
                        // 'student' => $the_event->student->name ?? $the_event->event->student->name,
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
