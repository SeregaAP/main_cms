@extends('install.layout')

@section('content')
<h2 class="text-2xl font-bold text-gray-800 mb-6">Создание администратора</h2>

<form method="POST" action="{{ route('install.admin.setup') }}">
    @csrf
    
    <div class="install_form">
        <div class="install_form_itm">
            <label>
                Имя администратора
                <input type="text" name="name" value="Admin"  required>
            </label>
        </div>

        <div class="install_form_itm">
            <label>
                Email
                <input type="email" name="email" required>
            </label>
        </div>

        <div class="install_form_itm">
            <label>
                Пароль
                <input type="password" name="password" required>
            </label>
        </div>

        <div class="install_form_itm">
            <label>
                Подтверждение пароля
                <input type="password" name="password_confirmation" required>
            </label>
        </div>
    </div>

    @if($errors->any())
    <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded-lg">
        <div class="flex items-center">
            <i class="fas fa-exclamation-triangle text-red-600 mr-2"></i>
            <span class="text-red-800 font-semibold">Ошибки:</span>
        </div>
        <ul class="list-disc list-inside text-red-700 mt-2">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="install_btn_group">
        <a href="{{ route('install.database') }}" 
           class="btn_all">
            <i class="fas fa-arrow-left mr-2"></i>
            Назад
        </a>

        <button type="submit" 
                class="btn_all">
            Завершить установку
            <i class="fas fa-check ml-2"></i>
        </button>
    </div>
</form>
@endsection