@extends('install.layout')

@section('content')
<div class="install_end">
    <h3 class="">Установка завершена!</h3>
    <p>
        Поздравляем! Ваша CMS успешно установлена и готова к использованию.
    </p>
    <div class="install_recomendation">
        <h4>Рекомендуемые действия:</h4>
        <ul>
            <li>Настройте параметры сайта в админ-панели</li>
            <li>Добавьте необходимый контент</li>
            <li>Настройте пользователей и права доступа</li>
        </ul>
    </div>
    <div class="install_btn_group">
        <x-btn_link 
            class="reg" 
            href="/" 
            text="На сайт" 
            icon="fas fa-home" 
            directions="right" />
        <x-btn_link 
            class="reg" 
            href="/login" 
            text="В админ-панель" 
            icon="fas fa-cog" 
            directions="right" />
    </div>
    <div class="log_important">
        <div class="log_header">
            <i class="fas fa-exclamation-triangle"></i>
            <span>Важно!</span>
        </div>
        <p class="log_text">
            Для безопасности удалите или переименуйте папку <code class="bg-yellow-100 px-1 rounded">install</code> 
            в корневой директории вашего сайта.
        </p>
    </div>
</div>
@endsection