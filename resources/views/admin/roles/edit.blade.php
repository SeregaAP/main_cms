@extends('admin.layout')

@section('content')

<section class="role_create">
    <div class="role_create_cnt">
        <form action="{{ route('roles.update', $role) }}" method="POST">
            @csrf @method('PUT')
            <div class="role_create_list">
                <div class="role_create_flex">
                    <div class="form-group">
                        <label class="title_permision">
                            Название роли *
                            <input type="text" name="name" class="form-control" value="{{ old('name', $role->name) }}" required>
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="title_permision">
                            Slug *
                            @if($role->is_system)
                                <input type="text" class="form-control" value="{{ $role->slug }}" readonly>
                                <small class="text-muted">Slug системной роли нельзя изменить</small>
                                <input type="hidden" name="slug" value="{{ $role->slug }}">
                            @else
                                <input type="text" name="slug" class="form-control" value="{{ old('slug', $role->slug) }}" required>
                            @endif
                        </label>
                    </div>
                </div>
                <div class="role_desc_group">
                    <label class="title_permision">
                        Описание
                        <textarea name="description" class="form-control" rows="3">{{ old('description', $role->description) }}</textarea>
                    </label>
                </div>

                <div class="permissions">
                    <span class="title_permision">Права доступа</span>
                    <div class="permissions_list">
                        @foreach($availablePermissions as $module => $actions)
                        <div class="permission_block">
                            <h6 class="font-weight-bold">{{ ucfirst($module) }}</h6>
                            <div class="permission_attr">
                                @foreach($actions as $action => $description)
                                <div class="attr_item">

                                        @php
                                            $isChecked = false;
                                            if (isset($role->permissions[$module])) {
                                                $isChecked = in_array('*', $role->permissions[$module]) || in_array($action, $role->permissions[$module]);
                                            }
                                        @endphp
                                        <label class="form-check-label" for="perm-{{ $module }}-{{ $action }}">
                                            {{ $description }}
                                            <input type="checkbox" 
                                               name="permissions[{{ $module }}][]" 
                                               value="{{ $action }}" 
                                               class="form-check-input" 
                                               id="perm-{{ $module }}-{{ $action }}"
                                               {{ $isChecked ? 'checked' : '' }}>
                                        </label>

                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn_all">
                    <i class="fas fa-save"></i> Обновить роль
                </button>
                @if(!$role->is_system && $role->users_count == 0)
                <button type="button" class="btn btn-danger float-right" onclick="confirmDelete()">
                    <i class="fas fa-trash"></i> Удалить роль
                </button>
                @endif
            </div>
        </form>
        @if(!$role->is_system && $role->users_count == 0)
        <form id="deleteForm" action="{{ route('roles.destroy', $role) }}" method="POST" class="d-none">
            @csrf @method('DELETE')
        </form>
        @endif
    </div>
</section>


@if(!$role->is_system && $role->users_count == 0)
<script>
function confirmDelete() {
    if (confirm('Вы уверены, что хотите удалить эту роль?')) {
        document.getElementById('deleteForm').submit();
    }
}
</script>
@endif
@endsection