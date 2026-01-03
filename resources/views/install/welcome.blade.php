@extends('install.layout')

@section('content')
<div class="welcome_cnt">
    <div class="welcome_slider">
        <img src="{{ asset('images/programmer-night.jpg') }}" alt="">
        <img src="{{ asset('images/noutbuks.jpg') }}" alt="">
        <img src="{{ asset('images/noutbuks-2.jpg') }}" alt="">
    </div>
    <div class="welcome_txt">
        <div class="text-group">
                <p>
                Этот мастер установки проведет вас через 
                процесс настройки вашей новой системы управления контентом.
            </p>
            <h2 class="font-semibold text-blue-800 mb-2">Перед началом убедитесь, что у вас есть:</h2>
            <ul>
                <li>Доступ к базе данных MySQL</li>
                <li>Данные для подключения к БД (хост, имя базы, пользователь, пароль)</li>
                <li>Информация для создания учетной записи администратора</li>
            </ul>
        </div>
        
        <x-btn_link class="reg" href="{{ route('install.requirements') }}" text="Далее" icon="fa-solid fa-arrow-right" />
    </div>
</div>
@endsection