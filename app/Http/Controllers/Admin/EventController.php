<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventStudent;
use App\Models\Teacher;
use App\Models\Student;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreEventRequest;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Response;

class EventController extends Controller
{
    public function store(StoreEventRequest $request)
    {   
        $this->authorize('create', Event::class);
        $name       = $request->name;
        $start_time = $request->start_time;
        $end_time   = $request->end_time;
        $end_loop   = $request->end_loop;
        $teacher_id = $request->teacher_id;
        $fee        = $request->fee;
        $recurrence = $request->recurrence ?? '';
        $recurrence_days   = $request->recurrence_days ?? [];
        
        try {
            $startTime = Carbon::parse($request->start_time);
            $finishTime = Carbon::parse($request->end_time);
            $durration = $finishTime->diffInMinutes($startTime);
            
            $event = new Event();
            $event->name = $name;
            $event->start_time = date('Y-m-d H:i:s', strtotime($start_time) );
            $event->end_time = date('Y-m-d H:i:s', strtotime($end_time) );
            $event->end_loop = date('Y-m-d', strtotime($end_loop) );
            $event->teacher_id = $teacher_id;
            $event->recurrence = $recurrence;
            $event->durration = $durration;
            $event->fee = $fee;
            $event->recurrence_days = implode(',',$recurrence_days);
            $event->save();
            $event->students()->attach($request->student_ids);

            if( $event && $recurrence == 'yes' ){
                $start_loop = date('Y-m-d', strtotime($start_time) );
                $end_loop   = date('Y-m-d', strtotime($end_loop) );
                $periods = CarbonPeriod::create($start_loop, $end_loop);
                if( count($periods) ){
                    foreach ($periods as $key => $date) {
                        if($key == 0){
                            continue;
                        }
                        $week_day_name = date('l',strtotime($date->format('Y-m-d')));
                        if( in_array($week_day_name,$recurrence_days) ){
                            $child_events = [
                                'name' => $event->name,
                                'durration' => $durration,
                                'event_id' => $event->id,
                                'teacher_id' => $teacher_id,
                                'fee' => $fee,
                                'start_time' => $date->format('Y-m-d').' '.date('H:i:s' , strtotime($event->start_time) ),
                                'end_time' => $date->format('Y-m-d').' '.date('H:i:s' , strtotime($event->end_time) ),
                            ];
                            Event::create($child_events);
                        }
                    }
                    
                }
            }
            return redirect()->route('systemCalendar');
        } catch (\Exception $e) {
            Log::error('message: ' . $e->getMessage() . ' line: ' . $e->getLine() . ' file: ' . $e->getFile());
            return redirect()->route('systemCalendar');
        }

    }

    public function update(Request $request, $id)
    {
        $this->authorize('update', Event::class);
        $data = $request->except(['_token','_method']);
        if( isset($data['recurrence_days']) ){
            $data['recurrence_days'] = implode(',',$data['recurrence_days']);
        }
        $item = Event::find($id);

        // Cập nhật cho sự kiện này và sự kiện trở về sau
        try {
            // Cập nhật cho sự kiện hiện tại
            $item->update($data);
            
            if($request->student_ids){
                if( $item->students->count() ){
                    $item->students()->sync($request->student_ids);
                }else{
                    $item->students()->attach($request->student_ids);
                }
            }
            // Cập nhật cho sự kiện tiếp theo
            if($request->update_feature){
                $next_events = Event::where('status','cho_thuc_hien');
                if( $item->recurrence ){
                    $next_events->where('event_id',$id);
                }else{
                    $next_events->where('event_id',$item->event_id);
                }
                $next_events->where('start_time','>',$item->start_time);
                $next_events = $next_events->get();
    
                if(count( $next_events )){
                    
                    foreach( $next_events as $next_event ){
                        $start_time = date('Y-m-d',strtotime($next_event->start_time));
                        $start_time.= ' '.date('H:i:s',strtotime($item->start_time));
    
                        $end_time = date('Y-m-d',strtotime($next_event->end_time));
                        $end_time.= ' '.date('H:i:s',strtotime($item->end_time));
                        
                        $startTime = Carbon::parse($start_time);
                        $finishTime = Carbon::parse($end_time);
                        $durration = $finishTime->diffInMinutes($startTime);
                        
                        $child_event = [
                            'name' => $request->name,
                            'durration' => $durration,
                            'teacher_id' => $request->teacher_id,
                            'fee' => $request->fee,
                            'start_time' => $start_time,
                            'end_time' => $end_time,
                        ];
                        $the_child_event = Event::find($next_event->id);
                        $the_child_event->update($child_event);
                        if($request->student_ids){
                            if( $the_child_event->students->count() ){
                                $the_child_event->students()->sync($request->student_ids);
                            }else{
                                $the_child_event->students()->attach($request->student_ids);
                            }
                        }
                    }
                }
            }
            return redirect()->route('events.index')->with('success', 'Cập nhật thành công !');
        } catch (\Exception $e) {
            Log::error('message: ' . $e->getMessage() . ' line: ' . $e->getLine() . ' file: ' . $e->getFile());
            return redirect()->route('events.index')->with('error', 'Cập nhật không thành công !');
        }
        
        return redirect()->route('systemCalendar');
    }
    public function index(Request $request , $status = '')
    {
        $this->authorize('viewAny', Event::class);


        $teacher_id       = $request->teacher_id ?? '';
        $student_id       = $request->student_id ?? '';
        $name             = $request->name ?? '';
        // $room_name        = $request->room_name ?? '';
        $orderby          = $request->orderby ?? '';
        $status_search            = $request->status ?? '';
        $start_time            = $request->start_time ?? '';
        $end_time            = $request->end_time ?? '';
        $teachers = Teacher::all();
        $students = Student::all();
        $status = new Event();
        $query = Event::query(true);
        
        // if (!empty($room_name)) {
        //     $query->where('group_id',  $request->room_name);
        // };
        
        if (!empty($student_id)) {
            $query->leftJoin('event_students', 'events.id', '=', 'event_students.event_id')
            ->where('event_students.student_id', $student_id);
     
        }
        if (!empty($teacher_id)) {
            $query->where('teacher_id',  $request->teacher_id);
        };
        if (!empty($orderby)) {
            $query->orderBy('events.id', $orderby);
        }
        if (!empty($name)) {
            $query->where('name', 'like', '%' . $name . '%');
        }
        if (!empty($status_search)) {
            $query->where('status', 'like', '%' . $status_search . '%');
        }
        if (!empty($start_time)) {
            $query->where('start_time', 'like', '%' . $start_time . '%');
        }
        if (!empty($end_time)) {
            $query->where('end_time', 'like', '%' . $end_time . '%');
        }

        $events = $query->paginate(10);
        $params = [
            'events'       => $events,
            'teachers'     => $teachers,
            'students'     => $students,
            'status'     => $status,
        ];
        return view('admin.events.index', $params);
    }

    public function create()
    {   
        $this->authorize('create', Event::class);
        $teachers = Teacher::all();
        $event = new Event();
        $params = [
            'teachers' => $teachers,
            'event' => $event
        ];
        return view('admin.events.create',$params);
    }

    public function edit(Event $event)
    {   
        $this->authorize('update', Event::class);
        // Nếu ko có danh sách học viên riêng thì lấy danh sách cha
        if( !count($event->students) ){
            $event->students = $event->event->students;
        }
        $event->recurrence_days = explode(',',$event->recurrence_days);
        $event->student_ids = $event->students ? implode(',',$event->students->pluck('id')->toArray()) : '';
        $teachers = Teacher::all();
        $students = Student::all();
        $params = [
            'teachers' => $teachers,
            'students' => $students,
            'event' => $event
        ];
        return view('admin.events.edit', $params);
    }

    public function show(Event $event)
    {
        // Nếu ko có danh sách học viên riêng thì lấy danh sách cha
        if( !count($event->students) ){
            $event->students = $event->event->students;
        }
        $this->authorize('view', Event::class);
        return view('admin.events.show', compact('event'));
    }

    public function destroy($id)
    { 
        try {
            $this->authorize('delete', Event::class);

            // Delete child
            Event::where('event_id', '=',$id)->delete();

            // Delete EventStudent
            EventStudent::where('event_id', '=',$id)->delete();

            // Delete main event
            $item = Event::where('id', '=',$id);
            $item->delete();

            
            return redirect()->route('events.index')->with('success', 'Xóa thành công !');

        } catch (\Exception $e) {
            Log::error('message: ' . $e->getMessage() . ' line: ' . $e->getLine() . ' file: ' . $e->getFile());
            return redirect()->route('events.index')->with('error', 'Xóa không thành công !');
        }
        
    }

    public function massDestroy(Request $request)
    {
        Event::whereIn('id', request('ids'))->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
    public function salary(Request $request)
    {
        $teacher_id       = $request->teacher_id ?? '';
        $student_id       = $request->student_id ?? '';
        $name             = $request->name ?? '';
        // $room_name        = $request->room_name ?? '';
        $orderby          = $request->orderby ?? '';
        $status_search            = $request->status ?? '';
        $start_time            = $request->start_time ?? '';
        $end_time            = $request->end_time ?? '';
        $teachers = Teacher::all();
        $students = Student::all();
        $status = new Event();
        $query = Event::where('status','da_xac_nhan');
        
        // if (!empty($room_name)) {
        //     $query->where('group_id',  $request->room_name);
        // };
        
        if (!empty($student_id)) {
            $query->leftJoin('event_students', 'events.id', '=', 'event_students.event_id')
            ->where('event_students.student_id', $student_id);
     
        }
        if (!empty($teacher_id)) {
            $query->where('teacher_id',  $request->teacher_id);
        };
        if (!empty($orderby)) {
            $query->orderBy('events.id', $orderby);
        }
        if (!empty($name)) {
            $query->where('name', 'like', '%' . $name . '%');
        }
        if (!empty($start_time)) {
            $query->where('start_time', 'like', '%' . $start_time . '%');
        }
        if (!empty($end_time)) {
            $query->where('end_time', 'like', '%' . $end_time . '%');
        }

        $events = $query->paginate(31);
        $params = [
            'items'       => $events,
            'teachers'     => $teachers,
            'students'     => $students,
            'status'     => $status,
        ];
        return view('admin.events.salary',$params);
    }
}
