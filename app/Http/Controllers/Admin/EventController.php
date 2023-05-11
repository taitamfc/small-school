<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventStudent;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Room;
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
            
            $item = new Event();
            $item->name = $name;
            $item->start_time = date('Y-m-d H:i:s', strtotime($start_time) );
            $item->end_time = date('Y-m-d H:i:s', strtotime($end_time) );
            $item->end_loop = date('Y-m-d', strtotime($end_loop) );
            $item->teacher_id = $teacher_id;
            $item->recurrence = $recurrence;
            $item->durration = $durration;
            $item->fee = $fee;
            $item->recurrence_days = implode(',',$recurrence_days);
            $item->save();
            if($request->student_ids){
                $item->students()->attach($request->student_ids);
            }

            if( $item && $recurrence == 'yes' ){
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
                                'name' => $item->name,
                                'durration' => $durration,
                                'event_id' => $item->id,
                                'teacher_id' => $teacher_id,
                                'fee' => $fee,
                                'start_time' => $date->format('Y-m-d').' '.date('H:i:s' , strtotime($item->start_time) ),
                                'end_time' => $date->format('Y-m-d').' '.date('H:i:s' , strtotime($item->end_time) ),
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

    public function update(StoreEventRequest $request, $id)
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
        $query->orderBy('events.id', 'DESC');
        
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

        $items = $query->paginate(30);
        $params = [
            'events'       => $items,
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
        $rooms = Room::all();
        $item = new Event();
        $item->recurrence_days = [];
        $params = [
            'teachers' => $teachers,
            'rooms' => $rooms,
            'item' => $item
        ];
        return view('admin.events.create',$params);
    }

    public function edit($id)
    {   
        $this->authorize('update', Event::class);
        $item = Event::find($id);
        // Nếu ko có danh sách học viên riêng thì lấy danh sách cha
        if( !count($item->students) ){
            $item->students = $item->event->students ?? null;
        }
        $item->recurrence_days = explode(',',$item->recurrence_days);
        $item->student_ids = $item->students ? implode(',',$item->students->pluck('id')->toArray()) : '';
        $teachers = Teacher::all();
        $rooms = Room::all();
        $params = [
            'teachers' => $teachers,
            'rooms' => $rooms,
            'item' => $item
        ];
        return view('admin.events.edit', $params);
    }

    public function show($id)
    {
        $item = Event::find($id);
        // Nếu ko có danh sách học viên riêng thì lấy danh sách cha
        if( !count($item->students) ){
            $item->students = $item->event ?  $item->event->students : [];
        }
        $this->authorize('view', Event::class);
        return view('admin.events.show', compact('item'));
    }

    public function destroy($id)
    { 
        try {
            $this->authorize('delete', Event::class);
            
            $item = Event::find($id);

            // Delete EventStudent
            $item->students()->detach();

            // Delete child
            $item->events()->delete();
            
            // Delete main event
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

        if (!empty($student_id)) {
            $query->leftJoin('event_students', 'events.id', '=', 'event_students.event_id')
            ->where('event_students.student_id', $student_id);
     
        }
        if (!empty($teacher_id)) {
            $query->where('teacher_id',  $request->teacher_id);
        }
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

        $items = $query->paginate(31);
        $params = [
            'items'       => $items,
            'teachers'     => $teachers,
            'students'     => $students,
            'status'     => $status,
        ];
        return view('admin.events.salary',$params);
    }

    public function tableList(Request $request){
        $teachers = Teacher::all();
        $students = Student::all();
        
        $query = Event::orderBy('id','ASC');
        if (!empty($request->teacher_id)) {
            $query->where('teacher_id',  $request->teacher_id);
        }
        $items = $query->paginate(31);
        
        $status = new Event();
        $params = [
            'items'       => $items,
            'teachers'     => $teachers,
            'students'     => $students,
            'status'     => $status,
        ];
        return view('admin.events.tableList',$params);
    }

    public function changeStatus(Request $request){
        $data = $request->except(['_token','_method']);
        $id = $request->id;
        $data['status'] = $data['status'] ? 'da_hoan_thanh' : 'chua_hoan_thanh';
        $item = Event::find($id)->update($data);
        return response()->json([
            'success' => true
        ]);
    }
}
