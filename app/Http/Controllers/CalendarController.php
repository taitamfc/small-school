<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Event;
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

    public function index()
    {
        $events = [];

        foreach ($this->sources as $source) {
            foreach ($source['model']::all() as $model) {
                $crudFieldValue = $model->getOriginal($source['date_field']);

                if (!$crudFieldValue) {
                    continue;
                }
                $model->load('event');
                $event = [];
                if((!empty($model->student) && !empty($model->teacher)) || (!empty($model->event->teacher) && !empty($model->event->student))){
                    $event = [
                        'teacher' => $model->teacher->name ?? $model->event->teacher->name,
                        'student' => $model->student->name ?? $model->event->student->name
                    ];
                }
                $events[] = [
                    'id' => $model->id,
                    'title' => trim($model->{$source['field']}),
                    'start' => $crudFieldValue,
                    'end'   => $model->{$source['end_field']} = date('Y-m-d', strtotime($model->{$source['end_field']})),
                    'url'   => route($source['route'], $model->id),
                    'arr' => $event
                ];
            }
        }

        return view('admin.calendars.index', compact('events'));
    }
}
