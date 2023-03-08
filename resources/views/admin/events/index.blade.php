@extends('admin.layouts.master')
@section('content')
  <div class="content-wrapper">
    <div class="container"><br>
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("events.create") }}">
                Thêm
            </a>
            <a class="btn btn-warning" href="{{ route("systemCalendar") }}">
                Trang lịch
            </a>
        </div>
    </div>
<div class="card">
    <div class="card-header">
        Danh sách
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Event">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            STT
                        </th>
                        <th>
                           Tên sự kiện
                        </th>
                        <th>
                            Bắt đầu
                        </th>
                        <th>
                            Kết thúc
                        </th>
                        <th>
                            Lặp lại
                        </th>
                        <th>
                            Sự kiện lặp
                        </th>
                        <th>
                            Thao tác
                        </th>
                    </tr>
                </thead>
                <tbody id="list-events">
                    <?php $arr = ['None' => 'Không lặp lại','Daily' => 'Hàng ngày','Weekly' => 'Hàng tuần','Monthly' => 'Hàng tháng'];
                    $recurrence = App\Models\Event::RECURRENCE_RADIO;?>
                    @foreach($events as $key => $event)
                        <tr data-entry-id="{{ $event->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $key + 1 }}
                            </td>
                            <td>
                                {{ $event->name ?? '' }}
                            </td>
                            <td>
                                <?php $datetime = new DateTime($event->start_time) ;echo date_format($datetime, "H:i:s - d/m/Y") ?? '' ?>
                            </td>
                            <td>
                                <?php $datetime = new DateTime($event->end_time) ;echo date_format($datetime, "H:i:s - d/m/Y") ?? '' ?>
                            </td>
                            <td>
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
                            <td>
                                {{ $event->event->name ?? 'Sự kiện gốc' }}
                            </td>
                            <td>
                                {{-- @can('event_show') --}}
                                    <a class="btn btn-xs btn-primary" href="{{ route('events.show', $event->id) }}">
                                        Xem
                                    </a>
                                {{-- @endcan --}}

                                {{-- @can('event_edit') --}}
                                    <a class="btn btn-xs btn-info" href="{{ route('events.edit', $event->id) }}">
                                        Sửa
                                    </a>
                                {{-- @endcan --}}

                                {{-- @can('event_delete') --}}
                                    <form action="{{ route('events.destroy', $event->id) }}" 
                                        method="POST" 
                                        onsubmit="return confirm('{{ $event->event_id == null ? ('Bạn cũng muốn xóa các sự kiện lặp lại trong tương lai') : 'Bạn có muốn xóa sự kiện này'}}');" style="display: inline-block;"
                                    >
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="Xóa">
                                    </form>
                                {{-- @endcan --}}

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


    </div>
</div>
</div>
</div>
@endsection
@section('footer_scripts')

<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('event_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.events.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    order: [[ 1, 'asc' ]],
    pageLength: 100,
  });
  $('.datatable-Event:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
<script>
    $(document).ready(function(){
      $("#search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#list-events tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });
</script>
@endsection