<?php

namespace App\Http\Controllers\Admin;

use App\Models\Task;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Event;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Task::query(true);
        $items = $query->paginate(5);
        $params = [
            'items'        => $items,
        ];
        return view('admin.tasks.index',$params);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $params = [
            'teachers' => Teacher::all()
        ];
        return view('admin.tasks.create',$params);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        
        $task = new Task();
        $task->name = $request->name;
        $task->start_time = $request->start_time;
        $task->end_time = $request->end_time;
        $task->teacher_id = $request->teacher_id;
        // $task->fee = $request->fee;
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
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
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
        return view('admin.tasks.edit',$params);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }
}
