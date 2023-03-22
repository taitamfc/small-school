<div class="modal fade" id="modal-calendar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Thông tin sự kiện</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered mb-0">
                    <tbody>
                        <tr>
                            <td>Tên</td>
                            <td id="md-cl-title"></td>
                        </tr>
                        <tr>
                            <td>Bắt đầu</td>
                            <td id="md-cl-start"></td>
                        </tr>
                        <tr>
                            <td>Kết thúc</td>
                            <td id="md-cl-end"></td>
                        </tr>
                        <tr>
                            <td>Giảng viên</td>
                            <td id="md-cl-teacher"></td>
                        </tr>
                        <tr>
                            <td>Sinh viên</td>
                            <td id="md-cl-student"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="md-cl-id" value="0">
                <a id="md-cl-url-edit" href="#" class="btn btn-info">Sửa</a>
                <button id="md-cl-url-delete" type="button" class="btn btn-danger">Xóa</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>