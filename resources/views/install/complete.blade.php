@extends('install.layout')

@section('content')
<div class="install_end">

    <h2 class="text-2xl font-bold text-gray-800 mb-4">Установка завершена!</h2>
    
    <p class="text-gray-600 mb-6">
        Поздравляем! Ваша CMS успешно установлена и готова к использованию.
    </p>

    <div class="install_recomendation">
        <h3>Рекомендуемые действия:</h3>
        <ul>
            <li>Настройте параметры сайта в админ-панели</li>
            <li>Добавьте необходимый контент</li>
            <li>Настройте пользователей и права доступа</li>
        </ul>
    </div>

    <div class="install_btn_group">
        <a href="/" 
           class="btn_all">
            <i class="fas fa-home mr-2"></i>
            На сайт
        </a>

        <a href="/admin" 
           class="btn_all">
            <i class="fas fa-cog mr-2"></i>
            В админ-панель
        </a>
    </div>

    <div class="log_important">
        <div class="log_header">
            <i class="fas fa-exclamation-triangle text-yellow-600 mr-2"></i>
            <span class="font-semibold text-yellow-800">Важно!</span>
        </div>
        <p class="log_text">
            Для безопасности удалите или переименуйте папку <code class="bg-yellow-100 px-1 rounded">install</code> 
            в корневой директории вашего сайта.
        </p>
    </div>
</div>
@endsection