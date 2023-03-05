
@extends('admin.layouts.master')
@section('content')

 

  <div class="content-wrapper">
    <div class="container">

        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1>Quản lý chức vụ</h1><br>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{ route('login') }}">Trang chủ</a></li>
                  <li class="breadcrumb-item active">Quản lý chức vụ</li>
                </ol>
              </div>
            </div>
          </div>
        </section>
    
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="card card-primary">
                    @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                  <div class="card-header">
              
                    <h3 class="card-title">Thêm chức vụ</h3><br>
                  </div>
                  <div class="card-body">
                      <form action="{{ route('groups.store') }}" method="POST" enctype="multipart/form-data" class="form">
                        @csrf
                      
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Tên Chức Vụ</label>
                                <input name="name" value="{{ old('name') }}" type="text" class="form-control"
                                    id="name" placeholder="Nhập Tên Chức Vụ">
                                    @error('name')
                                    <div ><code>{{ $message }}</code></div>
                                  @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                              <label for="description">Mô Tả Chức Vụ</label>
                              <textarea name="description" type="text" class="form-control"
                                  id="description" placeholder="Nhập Mô Tả Chức Vụ(Không bắt buộc)"></textarea>
                                  @error('description')
                                    <div ><code>{{ $message }}</code></div>
                                  @enderror
                          </div>
                      </div>
                        <div class="col-md-6">
                            <label for="">Cấp Quyền</label>
                        </div>
                        <div class="card-header col-md-12">
                            <input name="" value="" class="form-check-input checkbox_all" type="checkbox"
                                id="gridCheck">
                            <label class="form-check-label" for="gridCheck">
                               Cấp Toàn Bộ Quyền
                            </label>
                        </div>
                        <div class="custom-control custom-checkbox row d-flex mb-4">
                            @if (is_array($parent_roles) || is_object($parent_roles))
                            @foreach ($parent_roles as $parent_role)
                                <div class="cards col-md-12">
                                    <div class="card-header">
                                        <input name="" value="{{ $parent_role->id }}"
                                            class="form-check-input checkbox_parent checkbox_all_childrent"
                                            type="checkbox" id="gridCheck{{ $parent_role->id }}">
                                        <label class="form-check-label" for="gridCheck{{ $parent_role->id }}">
                                            {{ $parent_role->group_name }}
                                        </label>
                                    </div>
                                    <div class="card-body row d-flex">
                                        @foreach ($parent_role->childrentroles as $childrentrole)
                                            <div class="form-check col-3">
                                                <input name="roles_id[]" value="{{ $childrentrole->id }}"
                                                    class="form-check-input checkbox_childrent checkbox_all_childrent"
                                                    type="checkbox" id="gridCheck{{ $childrentrole->id }}">
                                                <label class="form-check-label"
                                                    for="gridCheck{{ $childrentrole->id }}">
                                                    {{ $childrentrole->group_name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                            @endif
                        </div>
                          <button type="submit" class="btn btn-primary">Thêm</button>
                          <a class="btn btn-danger" href="{{ route('groups.index') }}">Trở về</a>
                      </form>
                    </div>
                 
                </div>
              </div>
            </div>
          </div>
        </section>
    </div>
  </div>
@endsection