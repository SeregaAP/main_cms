<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('admin');
        }

        return back()->withErrors([
            'email' => 'Неверный email или пароль.',
        ]);
    }

     public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Обрабатываем регистрацию
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'country' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $defaultRole = Role::where('slug', 'user')->first();
        // Создаём пользователя
        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'country' => $request->country,
            'city' => $request->city,
            'password' => Hash::make($request->password),
             'role_id' => $defaultRole?->id ?? 1, // если нет — назначаем 1
        ]);

        // Авторизуем сразу после регистрации
        auth()->login($user);

        return redirect('/dashboard'); // или другая страница после входа
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')
            ->with('success', 'Вы успешно вышли из системы.');
    }
}
