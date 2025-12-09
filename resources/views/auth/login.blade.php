<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="authorize">
        <h1>Вход</h1>
        @if ($errors->any())
            <div style="color: red;">
                {{ $errors->first() }}
            </div>
        @endif
    
        <form method="POST" action="{{ url('/login') }}">
            @csrf
            <div class="authorize_cnt">
                <div class="form_group">
                    <label>
                        Email:
                        <input type="email" name="email" required>
                    </label>
                </div>
                <div class="form_group">
                    <label>
                        Пароль:
                        <input type="password" name="password" required>
                    </label>
                </div>
                <button class="btn_all" type="submit">Войти</button>
                </div>
        </form>
    </div>
</body>
</html>