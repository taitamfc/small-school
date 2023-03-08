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
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css' />

        <div id='calendar'></div>


    </div>
</div>
</div>
</div>
@endsection
@section('footer_scripts')

<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js'></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
<script>
    $(document).ready(function () {
            events ={!! json_encode($events) !!};
            $('#calendar').fullCalendar({
           
                events: events,
                editable: true,
                timeFormat: ' HH:mmp',
                displayEventTime: true,
                eventRender: function(events, element) {
                    element.find('.fc-title').append('<br>GV: '+ events.arr['teacher']+" & HS: "+ events.arr['student']);
                },
                eventDrop: function(event) {
                    var id = event.id;
                    var start_time = moment(event.start).format('YYYY-MM-DD');
                    var end_time = moment(event.end).format('YYYY-MM-DD');
                    $.ajaxSetup({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                    });
                    $.ajax({
                            url:"{{ route('events.update', '') }}" +'/'+ id,
                            type:"PATCH",
                            dataType:'json',
                            data:{ start_time, end_time},
                            success:function(response)
                            {
                               
                            },
                            error:function(error)
                            {
                                console.log(error)
                            },
                        });
                },
            })
        });
</script>
@endsection