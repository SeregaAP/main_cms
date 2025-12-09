@extends('install.layout')

@section('content')
<div class="text-welcome">
    <div class="install_logo">
        <div class="cms-logo">
            <div class="logo-icon">
                <i class="fas fa-cube"></i>
            </div>
            LUMIX
        </div>
    </div>
    <p>
        Этот мастер установки проведет вас через процесс настройки вашей новой системы управления контентом.
    </p>
    <div class="install_welcome-inf">
        <h3 class="font-semibold text-blue-800 mb-2">Перед началом убедитесь, что у вас есть:</h3>
        <ul>
            <li>Доступ к базе данных MySQL</li>
            <li>Данные для подключения к БД (хост, имя базы, пользователь, пароль)</li>
            <li>Информация для создания учетной записи администратора</li>
        </ul>
    </div>

    <a href="{{ route('install.requirements') }}" 
       class="btn_all">
        Начать установку
        <i class="fas fa-arrow-right"></i>
    </a>
</div>
@endsection