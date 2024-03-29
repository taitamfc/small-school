<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreEventRequest;



class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $teacher_id         = $request->teacher_id ?? '';
        $search           = $request->key ?? '';
        $event_name        = $request->event_name ?? '';
        $status        = $request->status ?? '';
        $name        = $request->name ?? '';
        $orderby          = $request->orderby ?? '';
        $start_time            = $request->start_time ?? '';
        $end_time            = $request->end_time ?? '';
        $teachers = Teacher::all();
        $query = Task::query(true);
    
        if (!empty($teacher_id)) {
            $query->where('teacher_id',  $teacher_id);
        };
        if (!empty($orderby)) {
            $query->orderBy('id', $orderby);
        }
        if (!empty($event_name)) {
            $query->where('event_name', 'like', '%' . $event_name . '%');
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
        if (!empty($status)) {
            $query->where('status', 'like', '%' . $status . '%');
        }
        if (!empty($search)) {
            $query->where(function($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('event_name', 'like', '%' . $search . '%');
            });
        }
        
        $items = $query->paginate(5);
        $params = [
            'items'        => $items,
            'teachers'        => $teachers,
            'item'        => new Task(),
        ];
        return view('teachers.tasks.index',$params);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        $params = [
            'teachers' => Teacher::all(),
            'item' => new Task()
        ];
        return view('teachers.tasks.create',$params);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRequest $request)
    {
        
        $teacher_id = Auth::guard('teachers')->user()->id;

        $task = new Task();
        $task->name = $request->name;
        $task->start_time = $request->start_time;
        $task->end_time = $request->end_time;
        $task->teacher_id = $teacher_id;
        $task->description = $request->description;
        $task->status = $request->status;
        $task->event_name = $request->event_name;
        $task->fee = $request->fee;
        $task->end_loop = $request->end_loop;
        $task->recurrence = $request->recurrence;
        $task->status = 'cho_xac_nhan';
        if($request->recurrence_days && count($request->recurrence_days)){
            $task->recurrence_days = implode(',',$request->recurrence_days);
        }
        if($request->student_ids && count($request->student_ids)){
            $task->student_ids = implode(',',$request->student_ids);
        }
        try {
            $task->save();
            return redirect()->route('teachers.tasks.index')->with('success', 'Lưu thành công.');
        } catch (\Exception $e) {
            dd($e->getMessage());
            Log::error('message: ' . $e->getMessage() . ' line: ' . $e->getLine() . ' file: ' . $e->getFile());
            return back()->withInput()->with('error', 'Lưu không thành công!.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        // dd($task);
        $task->recurrence_days = ($task->recurrence_days) ? explode(',',$task->recurrence_days) : []; 
        $event = new Event();
        $student_ids = ($task->student_ids) ? explode(',',$task->student_ids) : []; 
        if( count($student_ids) ){
            $event->students = Student::whereIn('id',$student_ids)->get();;
        }
        $params = [
            'teachers' => Teacher::all(),
            'item' => $task,
            'event' => $event
        ];
        return view('teachers.tasks.edit',$params);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $task = Task::find($task->id);
        $task->name = $request->name;
        $task->start_time = $request->start_time;
        $task->end_time = $request->end_time;   
        $task->teacher_id = $request->teacher_id;
        $task->description = $request->description;
        $task->status = 'cho_xac_nhan';
        $task->event_name = $request->event_name;
        $task->fee = $request->fee;
        $task->end_loop = $request->end_loop;
        $task->recurrence = $request->recurrence;
        if($request->recurrence_days && count($request->recurrence_days)){
            $task->recurrence_days = implode(',',$request->recurrence_days);
        }
        if($request->student_ids && count($request->student_ids)){
            $task->student_ids = implode(',',$request->student_ids);
        }
        try {
            $task->save();
            return redirect()->route('teachers.tasks.index')->with('success', 'Lưu thành công.');
        } catch (\Exception $e) {
            dd($e->getMessage());
            Log::error('message: ' . $e->getMessage() . ' line: ' . $e->getLine() . ' file: ' . $e->getFile());
            return back()->withInput()->with('error', 'Lưu không thành công!.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        try {
            $task = Task::find($task->id);
            $task->delete();
            return redirect()->route('teachers.tasks.index')->with('success', 'Xóa thành công.');
        } catch (\Exception $e) {
            Log::error('message: ' . $e->getMessage() . ' line: ' . $e->getLine() . ' file: ' . $e->getFile());
            return redirect()->route('teachers.tasks.index')->with('success', 'Xóa không thành công.');

        }
      
       
    }
}