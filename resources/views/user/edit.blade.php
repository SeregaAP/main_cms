@extends('admin.layout')

@section('content')

<form class="create_form_doc" action="{{ route('users.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form_scroll_all">
        <div class="form_row">
            <div class="form-group">
                <label >
                    Имя
                    <input placeholder="Имя" class="form-control" type="text" name="name" value="{{ $user->name }}" required>
                </label>
            </div>
            <div class="form-group">
                <label>
                    Email
                    <input class="form-control" type="text" name="email" value="{{ $user->email }}" required>
                </label>
            </div>
            <div class="form-group">
                <label>
                    Страна
                    <input class="form-control" type="text" name="country" value="{{ $user->country }}" required>
                </label>
            </div>
            <div class="form-group">
                <label>
                    Город
                    <input class="form-control" type="text" name="city" value="{{ $user->city}}" required>
                </label>
            </div>
            <div class="form-group">
                <label>
                    Телефон
                    <input class="form-control" type="text" name="phone" value="{{ $user->phone }}" required>
                </label>
            </div>
            <div class="form-group">
                <label>
                    <input class="user_avatar_input" name="avatar" value="{{ $user->avatar }}" type="text">
                </label>
                <button type="button" class="user_btn_avatar_upload">загрузить аватар</button>
            </div>
        </div>
        
        
        <button type="submit" class="btn btn_all">{{__('create')}}</button>
    </div>
</form>
<x-modal-upload-img-all inputSelector=".user_avatar_input" />
@endsection