@extends('admin.layout')

@section('content')


<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    @if(auth()->user()->hasPermission('roles', 'create'))
                    <a href="{{ route('roles.create') }}" class="btn btn-primary float-right">
                        <i class="fas fa-plus"></i> Создать роль
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <section class="role_list_cnt">
    <ul class="role_list">
        @foreach($roles as $role)
            <div class="role_itm">
                <div class="role_itm_header">
                    <span class="role_id">{{ $role->id }}</span>
                    <span class="role_name">{{ $role->name }}</span>
                </div>
                <div class="role_itm_txt">
                    <ul>
                        <li class="role_slug">{{ $role->slug }}</li>
                        <li class="role_desc">{{ $role->description }}</li>
                        <li class="user_count">Количество пользователей: {{ $role->users_count }}</li>
                    </ul>
                </div>

                <td>
                    @if($role->is_system)
                        <span class="badge badge-secondary">Системная</span>
                    @else
                        <span class="badge badge-info">Пользовательская</span>
                    @endif
                </td>
                <td>
    {{-- Показываем кнопки редактирования для ВСЕХ ролей --}}
    <a href="{{ route('roles.edit', $role) }}" class="btn btn-sm btn-primary">
        <i class="fas fa-edit"></i>
    </a>
    
    {{-- Удаление только для несистемных ролей без пользователей --}}
    @if(!$role->is_system && $role->users_count == 0)
        <form action="{{ route('roles.destroy', $role) }}" method="POST" class="d-inline">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Удалить роль?')">
                <i class="fas fa-trash"></i>
            </button>
        </form>
    @endif
</td>
            </div>
        @endforeach
    </ul>
</section>
</div>
@endsection