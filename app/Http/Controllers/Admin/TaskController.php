<?php

namespace App\Http\Controllers\Admin;

use App\Models\Task;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Event;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        return view('admin.tasks.index',$params);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        $item = new Task();
        $item->recurrence_days = [];
        $params = [
            'teachers' => Teacher::all(),
            'item' => $item
        ];
        return view('admin.tasks.create',$params);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        
        $item = new Task();
        $item->name = $request->name;
        $item->start_time = $request->start_time;
        $item->end_time = $request->end_time;
        $item->teacher_id = $request->teacher_id;
        $item->description = $request->description;
        $item->status = $request->status;
        $item->event_name = $request->event_name;
        $item->fee = $request->fee;
        $item->end_loop = $request->end_loop;
        $item->recurrence = $request->recurrence;
        if($request->recurrence_days && count($request->recurrence_days)){
            $item->recurrence_days = implode(',',$request->recurrence_days);
        }
        if($request->student_ids && count($request->student_ids)){
            $item->student_ids = implode(',',$request->student_ids);
        }
        try {
            $item->save();
            return redirect()->route('tasks.index')->with('success', 'Lưu thành công.');
        } catch (\Exception $e) {
            dd($e->getMessage());
            Log::error('message: ' . $e->getMessage() . ' line: ' . $e->getLine() . ' file: ' . $e->getFile());
            return back()->withInput()->with('error', 'Lưu không thành công!.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $item)
    {
        // dd($item);
        $item->recurrence_days = ($item->recurrence_days) ? explode(',',$item->recurrence_days) : []; 
        $event = new Event();
        $student_ids = ($item->student_ids) ? explode(',',$item->student_ids) : []; 
        if( count($student_ids) ){
            $event->students = Student::whereIn('id',$student_ids)->get();;
        }
        $params = [
            'teachers' => Teacher::all(),
            'item' => $item,
            'event' => $event
        ];
        return view('admin.tasks.edit',$params);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $item)
    {
        $item = Task::find($item->id);
        $item->name = $request->name;
        $item->start_time = $request->start_time;
        $item->end_time = $request->end_time;   
        $item->teacher_id = $request->teacher_id;
        $item->description = $request->description;
        $item->status = $request->status;
        $item->event_name = $request->event_name;
        $item->fee = $request->fee;
        $item->end_loop = $request->end_loop;
        $item->recurrence = $request->recurrence;
        if($request->recurrence_days && count($request->recurrence_days)){
            $item->recurrence_days = implode(',',$request->recurrence_days);
        }
        if($request->student_ids && count($request->student_ids)){
            $item->student_ids = implode(',',$request->student_ids);
        }
        try {
            $item->save();
            return redirect()->route('tasks.index')->with('success', 'Lưu thành công.');
        } catch (\Exception $e) {
            // dd($e->getMessage());
            Log::error('message: ' . $e->getMessage() . ' line: ' . $e->getLine() . ' file: ' . $e->getFile());
            return back()->withInput()->with('error', 'Lưu không thành công!.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $item)
    {
        try {
            $item = Task::find($item->id);
            $item->delete();
            return redirect()->route('tasks.index')->with('success', 'Xóa thành công.');
        } catch (\Exception $e) {
            Log::error('message: ' . $e->getMessage() . ' line: ' . $e->getLine() . ' file: ' . $e->getFile());
            return redirect()->route('tasks.index')->with('success', 'Xóa không thành công.');

        }
      
       
    }
}
