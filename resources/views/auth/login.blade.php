<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>LUMIX</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="authorize">
        <div class="container">
            <div class="authorize_cnt">
                <div class="authorize_img">
                    <img src="{{ asset('images/bg_autorize.png') }}" alt="">
                </div>
                <div class="authorize_form">
                    <div class="authorize_header">
                        <svg width="45" height="45" viewBox="0 0 45 45" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="44.9824" height="44.9824" rx="11" fill="#2ECC71"/>
                            <path d="M30.5509 10.9436C30.4372 10.7164 30.2625 10.5254 30.0464 10.3918C29.8303 10.2583 29.5812 10.1875 29.3272 10.1875H15.654C15.1358 10.1875 14.6627 10.4801 14.4302 10.9436L8.96095 21.8822C8.8659 22.0721 8.81641 22.2816 8.81641 22.4941C8.81641 22.7065 8.8659 22.916 8.96095 23.1059L14.4302 34.0445C14.6627 34.5066 15.1358 34.7993 15.654 34.7993H29.3272C29.8454 34.7993 30.3185 34.5067 30.5509 34.0431L36.0202 23.1046C36.1153 22.9146 36.1648 22.7051 36.1648 22.4927C36.1648 22.2803 36.1153 22.0708 36.0202 21.8808L30.5509 10.9436ZM32.5841 21.1261H21.9683L17.8663 12.9221H28.4822L32.5841 21.1261ZM11.7134 22.4934L15.654 14.6121L19.5946 22.4934L15.654 30.3746L11.7134 22.4934ZM28.4822 32.0646H17.8663L21.9683 23.8607H32.5841L28.4822 32.0646Z" fill="white"/>
                        </svg>
                        <h1>LUMIX</h1>
                    </div>
                    <form method="POST" action="{{ url('/login') }}">
                        @csrf
                        <x-input 
                            placeholder="email" 
                            type="email" 
                            name="email" 
                            label="Email:" 
                            :required="true"
                            autocomplete="email"
                            autofocus
                            maxlength="255"
                        />
                        <x-input 
                            placeholder="Пароль" 
                            type="password" 
                            name="password" 
                            label="Пароль:" 
                            :required="true"
                            autocomplete="password"
                            autofocus
                            maxlength="255"
                        />
                        <x-btn type="submit" text="Войти" />
                    </form>
                </div>
            </div>
            @if ($errors->any())
                <div style="color: red;">
                    {{ $errors->first() }}
                </div>
            @endif
        </div>
    </div>
</body>
</html>