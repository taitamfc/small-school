@extends('teachers.layouts.master')
@section('content')
    <div class="content-wrapper">
        <div class="container"><br>
            <div style="margin-bottom: 10px;" class="row">
                <div class="col-lg-12">
                    <a class="btn btn-warning" href="{{ route("teachers.events.index") }}">
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
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                "content"
            ),
        },
        dataType:'json',
        error:function(error)
        {
            console.log(error.responseJSON.message);
        }
    });
</script>
<script src="{{asset('js/admin-calendar.js')}}"></script>
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
    $('#md-cl-url-delete').remove();
    $('#md-cl-url-edit').text('Chi tiết');

    var calendarEl = document.getElementById('calendar');
    var Calendar = FullCalendar.Calendar;
    var calendar = new Calendar(calendarEl, {
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        themeSystem: 'bootstrap',
        events: "{{ route('teachers.events.calendar') }}",
        eventClick: function(info) {
            $('#md-cl-id').val(info.event.id);
            $('#md-cl-title').text(info.event.title);
            $('#md-cl-start').text(info.event.extendedProps.arr.start_format);
            $('#md-cl-end').text(info.event.extendedProps.arr.end_format);
            $('#md-cl-teacher').text(info.event.extendedProps.arr.teacher);
            $('#md-cl-student').text(info.event.extendedProps.arr.student);
            $('#md-cl-url-edit').attr('href',info.event.extendedProps.arr.url);
            $('#modal-calendar').modal('show');
        }
    });
    calendar.render();
});
</script>
@endsection