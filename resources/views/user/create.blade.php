@extends('admin.layout')

@section('content')

<form class="create_form_doc" action="{{ route('users.store') }}" method="POST">
    @csrf
    <div class="form_scroll_all">
        <div class="form_row">
            <div class="form-group">
                <label >
                    Имя
                    <input placeholder="Имя" class="form-control" type="text" name="name" value="{{ old('name') }}" required>
                </label>
            </div>
            <div class="form-group">
                <label>
                    Email
                    <input class="form-control" type="text" name="email" value="{{ old('email') }}" required>
                </label>
            </div>
            <div class="form-group">
                <label>
                    Страна
                    <input class="form-control" type="text" name="country" value="{{ old('country') }}" required>
                </label>
            </div>
            <div class="form-group">
                <label>
                    Город
                    <input class="form-control" type="text" name="city" value="{{ old('city') }}" required>
                </label>
            </div>
            <div class="form-group">
                <label>
                    Телефон
                    <input class="form-control" type="text" name="phone" value="{{ old('phone') }}" required>
                </label>
            </div>
            <div class="form-group">
                <label>
                    Роль пользователя
                    <input   require  name="slug"  class="doc_parent" type="text" value="" placeholder="-- --" required>
                </label>
                <div class="form-select_group">
                    <div class="select_group_control">
                        <span class="doc_name">Выберите роль</span>
                        <button class="select_btn_open" type="button">
                            <i class="fa-solid fa-list"></i>
                        </button>
                    </div>
                    <div class="select_option_list">
                        @foreach ($roles as $role)
                            <div class="select_option_itm" data-value="{{ $role->slug }}">{{ $role->name }}</div>
                        @endforeach
                        
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>
                    Пароль
                    <input class="form-control" type="password" name="password" required>
                </label>
            </div>
            <div class="form-group">
                <label>
                    Подтверждение пароля:
                    <input class="form-control" type="password" name="password_confirmation" required>
                </label>
            </div>       
        </div>
        
    
        <button type="submit" class="btn btn_all">{{__('create')}}</button>
    </div>
</form>

@endsection