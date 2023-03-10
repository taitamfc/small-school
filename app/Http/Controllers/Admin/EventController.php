<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Teacher;
use App\Models\Student;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreEventRequest;

class EventController extends Controller
{
    //
    public function store(StoreEventRequest $request)
    {   
        try {
            Event::create($request->all());
            return redirect()->route('systemCalendar');
        } catch (\Exception $e) {
            Log::error('message: ' . $e->getMessage() . ' line: ' . $e->getLine() . ' file: ' . $e->getFile());
            // return back()->with('error', 'Export không thành công!.');
            return redirect()->route('systemCalendar');
        }

    }

    public function update(Request $request, Event $event)
    {
        $item = Event::where('id', '=',$event->id);
        $data = $request->except(['_token','_method']);
        $item->update($data);
        return redirect()->route('systemCalendar');
    }
    public function index()
    {
       

        $events = Event::withCount('events')
            ->get();

        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        $teachers = Teacher::all();
        $students = Student::all();
        $params = [
            'teachers' => $teachers,
            'students' => $students
        ];
        return view('admin.events.create',$params);
    }

    public function edit(Event $event)
    {
        $event->load('event')
        ->loadCount('events');
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
      
        $event->load('event');
        return view('admin.events.show', compact('event'));
    }

    public function destroy(Event $event)
    { 
        try {
        $item = Event::where('id', '=',$event->id);
        $item->delete();
    } catch (\Exception $e) {
        $item = Event::where('event_id', '=',$event->id);
        $item->delete();
        $event->delete();
    }
        

        return back();
    }

    public function massDestroy(Request $request)
    {
        Event::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
