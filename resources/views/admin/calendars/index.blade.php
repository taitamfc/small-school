@extends('admin.layouts.master')
@section('content')
    <div class="content-wrapper">
        <div class="container"><br>
            <div style="margin-bottom: 10px;" class="row">
                <div class="col-lg-12">
                    <a class="btn btn-success" href="{{ route("events.create") }}">
                        Thêm
                    </a>
                    <a class="btn btn-warning" href="{{ route("events.index") }}">
                        Danh sách sự kiện
                    </a>
                </div>
            </div>
            <div class="card">
                <div class="card-header">

                </div>
                <div class="card-body">
                    <div id='calendar'></div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.calendars.modal-info')
@endsection
@section('footer_scripts')
<link rel="stylesheet" href="{{asset('asset/plugins/fullcalendar/main.css')}}">
<script src="{{asset('asset/plugins/fullcalendar/main.js')}}"></script>
<script>
/*
    // Allday
    {
        title          : 'All Day Event',
        start          : new Date(y, m, 1),
        backgroundColor: '#f56954', //red
        borderColor    : '#f56954', //red
        allDay         : true
    }
    // Normal event
    {
        title          : 'Long Event',
        start          : new Date(y, m, d - 5),
        end            : new Date(y, m, d - 2),
        backgroundColor: '#f39c12', //yellow
        borderColor    : '#f39c12' //yellow
    }
    */
$(document).ready(function() {
    let events = {!!json_encode($events) !!};
    console.log(events);
    var calendarEl = document.getElementById('calendar');
    var Calendar = FullCalendar.Calendar;
    var calendar = new Calendar(calendarEl, {
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        themeSystem: 'bootstrap',
        events: events,
        // editable  : true,
        eventClick: function(info) {
            console.log(info.event.extendedProps);
            $('#md-cl-title').text(info.event.title);
            $('#md-cl-start').text(info.event.extendedProps.arr.start_format);
            $('#md-cl-end').text(info.event.extendedProps.arr.end_format);
            $('#md-cl-teacher').text(info.event.extendedProps.arr.teacher);
            $('#md-cl-student').text(info.event.extendedProps.arr.student);
            $('#modal-calendar').modal('show');
        }
    });

    calendar.render();
});
</script>
@endsection