@extends('teachers.layouts.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Cập nhật thông tin</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="">Trang chủ</a></li>
                        <li class="breadcrumb-item active">Cập nhật thông tin</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">

                    <div class="card">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img style="width:200px;" class="profile-user-img img-fluid img-circle"
                                    src="{{ !empty($teacher->image) ? asset($teacher->image) : 'https://vivureviews.com/wp-content/uploads/2022/08/avatar-vo-danh-10.png' }}"
                                    alt="User profile picture" id="previewImage"
                                    onerror="this.src='https://vivureviews.com/wp-content/uploads/2022/08/avatar-vo-danh-10.png'">
                            </div>

                            <h3 class="profile-username text-center">
                                {{ !empty(($teacher->name)) ? $teacher->name : ""  }}</h3>

                            <p class="text-muted text-center">Giáo viên</p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Email</b> <a
                                        class="float-right">{{ !empty(($teacher->email)) ? $teacher->email : ""  }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Cấp độ</b> <a
                                        class="float-right">{{ !empty(($teacher->level)) ? $teacher->level : ""  }}</a>
                                </li>
                            </ul>


                        </div>
                    </div>

                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('teachers.postProfile',$teacher->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-2 col-form-label">Họ và tên</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="name"
                                            value="{{ !empty(($teacher->name)) ? $teacher->name : ""  }}" id="inputName"
                                            placeholder="Họ và tên">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" name="email"
                                            value="{{ !empty(($teacher->email)) ? $teacher->email : ""  }}"
                                            id="inputEmail" placeholder="Email">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputName2" class="col-sm-2 col-form-label">Mật khẩu</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" name="password" id="inputName2"
                                            placeholder="Mật khẩu(nếu muốn thay đổi hãy nhập)">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputExperience" class="col-sm-2 col-form-label">Ảnh cá nhân</label>
                                    <div class="col-sm-10">
                                        <input type="file" name="inputFile" id="imageUpload" placeholder="Mật khẩu">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <button type="submit" class="btn btn-danger">Cập nhật</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('footer_scripts')
<script>
const imageUpload = document.getElementById('imageUpload');
const previewImage = document.getElementById('previewImage');
imageUpload.addEventListener('change', function() {
    const file = this.files[0];
    const reader = new FileReader();
    reader.addEventListener('load', function() {
        previewImage.src = reader.result;
    });
    reader.readAsDataURL(file);
});
</script>
@endsection