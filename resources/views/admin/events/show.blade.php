@extends('admin.layouts.master')
@section('content')
  <div class="content-wrapper">
    <div class="container"><br>
<div class="card">
    <div class="card-header">
        
        <h4><b>Chi tiết sự kiện</b></h4>
    </div>

    <div class="card-body">
        <div class="mb-2">
            <form action="{{ route("events.update", [$item->id]) }}" 
                method="POST" 
                enctype="multipart/form-data" 
                @if($item->events_count || $item->event) onsubmit="return confirm('Bạn chắc chắn cập nhật?');" @endif
            >
            @csrf
            @method('PUT')
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            ID
                        </th>
                        <td>
                            {{ $item->id }}
                        </td>
                    </tr>
                    <tr>
                        <th> Tên sự kiện </th>
                        <td> {{ $item->name }} </td>
                    </tr>
                    <tr>
                        <th> Thời lượng </th>
                        <td> {{ $item->durration }} </td>
                    </tr>
                    <tr>
                        <th> Tiền công/giờ </th>
                        <td> {{ $item->fee }} </td>
                    </tr>
                    <tr>
                        <th> Trạng thái </th>
                        <td> {{ $item->statuses[$item->status] }} </td>
                    </tr>
                    <tr>
                        <th>
                            Giáo viên
                        </th>
                        <td>
                            {{ $item->teacher->name ?? $item->event->teacher->name}}
                        </td>
                    </tr>
                    <tr>
                        <th>
                           Bắt đầu
                        </th>
                        <td>
                            <?php $datetime = new DateTime($item->start_time) ;echo date_format($datetime, "H:i:s - d/m/Y") ?? '' ?>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Kết thúc
                        </th>
                        <td>
                            <?php $datetime = new DateTime($item->end_time) ;echo date_format($datetime, "H:i:s - d/m/Y") ?? '' ?>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Người tham gia
                        </th>
                        <td>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Mã</th>
                                        <th>Tên</th>
                                        <th>Số điện thoại</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody id="student_tb">
                                    @if( isset($item->students) && count($item->students) )
                                        @foreach( $item->students as $key => $student )
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $student->id }}</td>
                                            <td>{{ $student->name }}</td>
                                            <td>{{ $student->phone }}</td>
                                            <td>{{ $student->email }}</td>
                                        </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Bằng chứng thực hiện
                        </th>
                        <td>
                            {{ $item->proof }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Cập nhật trạng thái
                        </th>
                        <td>
                            <select name="status" class="form-control">
                                @foreach( $item->statuses as $status => $lb_status )
                                <option 
                                    @selected( $status == $item->status )
                                    value="{{ $status }}"
                                >{{ $lb_status }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    
                    
                </tbody>
            </table>
            <div class="form-group">
                <input class="btn btn-success" type="submit" value="Cập nhật">
                <a class="btn btn-danger" href="{{ route('events.index') }}">
                    Trở về
                 </a>
            </div>
            </form>
        </div>

        <nav class="mb-3">
            <div class="nav nav-tabs">

            </div>
        </nav>
        <div class="tab-content">

        </div>
    </div>
</div>
</div>
</div>
@endsection
