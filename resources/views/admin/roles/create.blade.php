
@extends('admin.layout')

@section('content')

<section class="role_create">
    <div class="role_create_cnt">
        <form action="{{ route('roles.store') }}" method="POST">
            @csrf
            <div class="role_create_list">
                <div class="role_create_flex">
                    <div class="form-group">
                        <label class="title_permision">
                            Название роли *
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="title_permision">
                            Slug *
                            <input type="text" name="slug" class="form-control" value="{{ old('slug') }}" required>
                        </label>
                    </div>
                </div>
                <div class="role_desc_group">
                    <label class="title_permision">
                        Описание
                        <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
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
                                        <label class="form-check-label" for="perm-{{ $module }}-{{ $action }}">
                                            {{ $description }}
                                            <input type="checkbox" 
                                               name="permissions[{{ $module }}][]" 
                                               value="{{ $action }}" 
                                               class="form-check-input" 
                                               id="perm-{{ $module }}-{{ $action }}"
                                               {{ in_array($action, old("permissions.{$module}", [])) ? 'checked' : '' }}>
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
                <button type="submit" class="btn_all">Создать роль</button>
            </div>
        </form>
    </div>
</section>

@endsection