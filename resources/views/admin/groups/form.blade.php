<div class="row">
    <div class="form-group col-lg-12">
        <label for="name">Tên Chức Vụ</label>
        <input name="name" value="{{ $item->name ?? old('name') }}" type="text"
            class="form-control" id="name" placeholder="Nhập Tên Chức Vụ">
        @error('name')
        @include('global_layouts.error')
        @enderror
    </div>
    <div class="form-group col-lg-12">
        <label for="description">Mô Tả Chức Vụ</label>
        <textarea name="description" type="text" class="form-control"
            id="description"
            placeholder="Nhập Mô Tả Chức Vụ(Không bắt buộc)">{{ $item->description ?? old('description') }}</textarea>
        @error('discription')
        @include('global_layouts.error')
        @enderror
    </div>
    <div class="form-group col-lg-12">
        <label for="">Cấp Quyền</label>
    </div>
    <div class="form-group col-lg-12">
        <input name="" value="" class="checkbox_all" type="checkbox"
            id="gridCheck">
        <label class="form-check-label" for="gridCheck">
            Cấp Toàn Bộ Quyền
        </label>
    </div>
    <div class="custom-control custom-checkbox row d-flex mb-4">
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
                        {{ $roles_checked->contains('id', $childrentrole->id) ? 'checked' : '' }}
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
    </div>
</div>

<script>
    $(document).ready( function(){
        $('.checkbox_all').click( function(){
            if($(this).is(':checked')){
                $('.checkbox_childrent').prop('checked',true);
            }else{
                $('.checkbox_childrent').prop('checked',false);
            }
        });

        $('.checkbox_parent').click( function(){
            if($(this).is(':checked')){
                $(this).closest('.cards').find('.checkbox_childrent').prop('checked',true);
            }else{
                $(this).closest('.cards').find('.checkbox_childrent').prop('checked',false);
            }
        });
    });
</script>