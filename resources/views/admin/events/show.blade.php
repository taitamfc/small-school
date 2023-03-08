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
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            ID
                        </th>
                        <td>
                            {{ $event->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Tên sự kiện
                        </th>
                        <td>
                            {{ $event->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Giáo viên
                        </th>
                        <td>
                            {{ $event->teacher->name ?? $event->event->teacher->name}}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Học sinh
                        </th>
                        <td>
                            {{ $event->student->name ?? $event->event->student->name}}
                        </td>
                    </tr>
                    <tr>
                        <th>
                           Bắt đầu
                        </th>
                        <td>
                            <?php $datetime = new DateTime($event->start_time) ;echo date_format($datetime, "H:i:s - d/m/Y") ?? '' ?>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Kết thúc
                        </th>
                        <td>
                            <?php $datetime = new DateTime($event->end_time) ;echo date_format($datetime, "H:i:s - d/m/Y") ?? '' ?>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Lặp lại
                        </th>
                        <td>
                            <?php $arr = ['None' => 'Không lặp lại','Daily' => 'Hàng ngày','Weekly' => 'Hàng tuần','Monthly' => 'Hàng tháng'];
                            $recurrence = App\Models\Event::RECURRENCE_RADIO;?>
                            <?php
                            switch ($recurrence[$event->recurrence]) {
                               case 'None':
                                  echo $arr['None'];
                                   break;
                               case 'Daily':
                                   echo $arr['Daily'];
                                   break;
                               case 'Weekly':
                                   echo $arr['Weekly'];
                                   break;
                               case 'Monthly':
                                   echo $arr['Monthly'];
                                   break;
                               default:
                                   break; }?>
                        </td>
                    </tr>
                    @if(isset($event->event->name))
                    <tr>
                        <th>
                            Sự kiện lặp lại
                        </th>
                        <td>
                            {{ $event->event->name ?? '' }}
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
            <a style="margin-top:20px;" class="btn btn-default" href="{{ url()->previous() }}">
                Trở về
            </a>
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
