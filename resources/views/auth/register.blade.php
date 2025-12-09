<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
</head>
<body>
    <h1>Регистрация</h1>

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ url('/register') }}">
        @csrf
        <div>
            <label>Имя:</label>
            <input type="text" name="name" value="{{ old('name') }}" required>
        </div>
        <div>
            <label>Телефон:</label>
            <input type="text" name="phone" value="{{ old('phone') }}" required>
        </div>
        <div>
            <label>Email:</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
        </div>
        <div>
            <label>Страна:</label>
            <input type="text" name="country" value="{{ old('country') }}" required>
        </div>
        <div>
            <label>Город:</label>
            <input type="text" name="city" value="{{ old('city') }}" required>
        </div>
        <div>
            <label>Пароль:</label>
            <input type="password" name="password" required>
        </div>
        <div>
            <label>Подтверждение пароля:</label>
            <input type="password" name="password_confirmation" required>
        </div>
        <button type="submit">Зарегистрироваться</button>
    </form>
</body>
</html>