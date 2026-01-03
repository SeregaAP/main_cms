@extends('install.layout')

@section('content')
<div class="create_admin">
    <h3>Создание администратора</h3>
    <form method="POST" action="{{ route('install.admin.setup') }}">
        @csrf    
        <div class="install_form">
            <x-input 
                placeholder="имя администратора" 
                type="text" 
                name="name" 
                label="Имя администратора" 
                :required="true"
                autocomplete="name"
                autofocus
                maxlength="255"
            />
            <x-input 
                placeholder="email" 
                type="email" 
                name="email" 
                label="Email" 
                :required="true"
                autocomplete="email"
                autofocus
                maxlength="255"
            />
            <x-input 
                placeholder="пароль" 
                type="password" 
                name="password" 
                label="Пароль" 
                :required="true"
                autocomplete="password"
                autofocus
                maxlength="255"
            />
            <x-input 
                placeholder="подтверждение пароля" 
                type="password" 
                name="password_confirmation" 
                label="Подтверждение пароля" 
                :required="true"
                autocomplete="password_confirmation"
                autofocus
                maxlength="255"
            />
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
            <x-btn_link 
            class="reg" 
            href="{{ route('install.database') }}" 
            text="Назад" 
            icon="fa-solid fa-arrow-right fa-rotate-180" 
            directions="left" />
            <x-btn 
            type="submit" 
            id="btn-final_install" 
            text="Завершить установку" 
            icon="fas fa-check" 
            />
        </div>
    </form>
</div>
@endsection