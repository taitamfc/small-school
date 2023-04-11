<style>.dataTables_filter { display: none; }</style>
<div class="modal fade" id="modal_students">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Danh sách học viên</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="student_ids" value="{{ $item->student_ids ?? '' }}">
                <div class="form-group">
                    <div class="row">
                        <div class="col">
                            <input id="dt_f_name" type="text" class="form-control" placeholder="Tìm theo tên">
                        </div>
                        <div class="col">
                            <input id="dt_f_email" type="text" class="form-control" placeholder="Tìm theo email">
                        </div>
                        <div class="col">
                            <input id="dt_f_phone" type="text" class="form-control" placeholder="Tìm theo phone">
                        </div>
                        <div class="col">
                            <select id="dt_f_room_id" class="form-control">
                                <option value="">Tất cả</option>
                            @if( isset($rooms) && count($rooms) )
                                @foreach( $rooms as $key => $froom )
                                <option value="{{ $froom->id }}">{{ $froom->name }}</option>
                                @endforeach
                            @endif
                            </select>
                        </div>
                        <div class="col-lg-1">
                            <input id="dt_do_search" type="button" class="btn btn-info" value="Tìm">
                        </div>
                    </div>
                </div>
                <table width="100%" id="modal_students_table" class="display dataTable table">
                    <thead>
                        <tr>
                            <th>Mã</th>
                            <th>Tên</th>
                            <th>Số điện thoại</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Mã</th>
                            <th>Tên</th>
                            <th>Số điện thoại</th>
                            <th>Email</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="modal-footer">
                <div class="form-check">
                    <label for="is_replace">
                        <input type="checkbox" value="1" id="is_replace"> Thay thế danh sách hiện tại ?
                    </label>
                </div>
                <button type="button" id="btn_modal_students_add" data-dismiss="modal" class="btn btn-success">Thêm</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <label>Danh sách học viên</label>
    <div>
        <table class="table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Mã</th>
                    <th>Tên</th>
                    <th>Số điện thoại</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="student_tb">
                @if( isset($item->students) && count($item->students) )
                    @foreach( $item->students as $key => $student )
                    <tr>
                        <td>{{ $key + 1 }}
                        <input type="hidden" name="student_ids[]" value="{{ $student->id }}">
                        </td>
                        <td>{{ $student->id }}</td>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->phone }}</td>
                        <td>{{ $student->email }}</td>
                        <td> <input type="button" class="btn btn-xs btn-danger student_tb_delete_row" value="Xóa"> </td>
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
    <div>
        <input class="btn btn-info" id="btn_modal_students" type="button" value="Thêm học viên">
        @error('student_ids')
        <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>
</div>

<script>
    jQuery( document ).ready( function(){
        var student_ids = $('#student_ids').val();
        student_ids = student_ids ? student_ids.split(',') : [];
        
        
        var table = $('#modal_students_table').DataTable( {
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("students.dataTable") }}',
                dataSrc: 'data',
                data: function (d) {
                    d.f_name = $('#dt_f_name').val();
                    d.f_email = $('#dt_f_email').val();
                    d.f_phone = $('#dt_f_phone').val();
                    d.f_room_id = $('#dt_f_room_id').val();
                    // d.custom = $('#myInput').val();
                    // etc
                },
            },
            select: {
                style:    'multi',
            },
            columns : [
                { data: 'id' },
                { data: 'name' },
                { data: 'phone' },
                { data: 'email' }
            ],
            dom: 'Bfrtip',
            buttons: [
                'pageLength',
                {
                    text: 'Chọn tất cả',
                    action: function ( e, dt, node, config ) {
                        dt.rows().select();
                    }
                },
                {
                    text: 'Bỏ chọn tất cả',
                    action: function ( e, dt, node, config ) {
                        dt.rows().deselect();
                    }
                }
            ],
            order: [[ 1, 'asc' ]]
        } );

        jQuery('#dt_do_search').on('click',function(){
            table.search('1111').draw()
        });
        jQuery('#btn_modal_students').on('click',function(){
            table.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
                var data = this.data();
                var checkId = data.id.toString();
                if( student_ids.indexOf(checkId) > -1 ){
                    // this.select();
                }
            } );

            jQuery('#modal_students').modal('show');
        });
        

        jQuery('#btn_modal_students_add').on('click',function(){
            let tb_html = '';
            let tb_row_data = table.rows('.selected').data();
            for( let i = 0; i < tb_row_data.length; i++ ){
                tb_html += `
                <tr>
                    <td>
                        ${ i + 1 } 
                        <input type="hidden" name="student_ids[]" value="${ tb_row_data[i].id }">
                    </td>
                    <td>${ tb_row_data[i].id }</td>
                    <td>${ tb_row_data[i].name }</td>
                    <td>${ tb_row_data[i].phone }</td>
                    <td>${ tb_row_data[i].email }</td>
                    <td><input type="button" class="btn btn-xs btn-danger student_tb_delete_row" value="Xóa"></td>
                </tr>
                `;
            }
            let is_replace = $('#is_replace').is(":checked");
            if(is_replace){
                $('#student_tb').html(tb_html);
            }else{
                $('#student_tb').append(tb_html);
            }
        });

        jQuery('body').on('click','.student_tb_delete_row',function(){
            let ask = confirm('Bạn có chắc chắn xóa ?');
            if(ask){
                jQuery(this).closest('tr').remove();
            }
        });
    });
</script>