@extends('admin.layout')

@section('content')
<h2>setings</h2>
<div class="setings_list">
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
    <div class="seting_itm">
        <form action="{{ route('settings.setHome') }}" method="POST">
            @csrf
            <label>Выберите главную страницу:</label>
            <select name="document_id" class="form-control">
                @foreach($documents as $doc)
                    <option value="{{ $doc->id }}" @if($home == $doc->id) selected @endif>
                        {{ $doc->title }}
                    </option>
                @endforeach
            </select>
        
            <button class="btn_all" type="submit">Сохранить</button>
        </form>
    </div>
    <div class="seting_itm">
    <form action="{{ route('settings.setLocale') }}" method="POST">
        @csrf
        <label>Выберите язык интерфейса:</label>
        <select name="locale" class="form-control">
            <option value="ru" @if($locale === 'ru') selected @endif>Русский</option>
            <option value="en" @if($locale === 'en') selected @endif>English</option>
            <option value="kz" @if($locale === 'kz') selected @endif>Казахский</option>
        </select>
        <button class="btn_all" type="submit">Сохранить</button>
    </form>
</div>
</div>
@endsection