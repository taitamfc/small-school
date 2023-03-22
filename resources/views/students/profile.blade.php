@extends('students.layouts.master')
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
                                <img style="width:200px" class="profile-user-img img-fluid img-circle"
                                    src="{{ !empty($student->image) ? asset($student->image) : 'https://vivureviews.com/wp-content/uploads/2022/08/avatar-vo-danh-10.png' }}"
                                    alt="User profile picture" id="previewImage"
                                    onerror="this.src='https://vivureviews.com/wp-content/uploads/2022/08/avatar-vo-danh-10.png'">
                            </div>

                            <h3 class="profile-username text-center">
                                {{ !empty(($student->name)) ? $student->name : ""  }}</h3>

                            <p class="text-muted text-center">Học sinh</p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Email</b> <a
                                        class="float-right">{{ !empty(($student->email)) ? $student->email : ""  }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Số điện thoại</b> <a
                                        class="float-right">{{ !empty(($student->phone)) ? $student->phone : ""  }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Sinh nhật</b> <a
                                        class="float-right">{{ !empty(($student->birthday)) ? date_format((new DateTime($student->birthday)),"d/m/Y") : ""  }}</a>
                                </li>
                            </ul>

                        </div>
                    </div>

                </div>
                <div class="col-md-8">
                    <div class="card">
                      
                        <div class="card-body">
                            <form action="{{ route('students.postProfile') }}" method="POST"
                                enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-2 col-form-label">Họ và tên</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="name"
                                            value="{{ !empty(($student->name)) ? $student->name : ""  }}" id="inputName"
                                            placeholder="Họ và tên">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-2 col-form-label">Số điện thoại</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="phone"
                                            value="{{ !empty(($student->phone)) ? $student->phone : ""  }}"
                                            id="inputName" placeholder="Họ và tên">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-2 col-form-label">Sinh nhật</label>
                                    <div class="col-sm-10">
                                        <input type="date" class="form-control" name="birthday"
                                            value="{{ !empty(($student->birthday)) ? $student->birthday : ""  }}"
                                            id="inputName" placeholder="Họ và tên">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" name="email"
                                            value="{{ !empty(($student->email)) ? $student->email : ""  }}"
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
                                        <input type="file" name="image" id="imageUpload" placeholder="Mật khẩu">
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