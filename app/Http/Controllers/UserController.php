<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class UserController extends Controller
{
    public function index(){
        $users = User::all();
        $pageTitle = __('users');
        $buttons = [
            [
                'href'  => route('users.create'),
                'label' => __('button_add'), // ключ label соответствует Blade
                'class' => 'btn btn-secondary'
            ]
        ];
        return view('user.index',compact('users','pageTitle','buttons'));
    }

    public function create()
    {
        $roles = Role::all();
        $pageTitle = __('add_user');
        $buttons = [
            ['href' => route('users.index'), 'label' => __('all_users'), 'class' => 'btn btn-secondary'],
        ];
    
        return view('user.create', compact('roles','pageTitle', 'buttons'));

    }

    public function store(Request $request)
    {
        // Валидация данных
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'country' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'password' => 'required|confirmed|min:6',
            'slug' => 'required|string|exists:roles,slug',
        ]);

        // Находим роль по slug
        $role = Role::where('slug', $validated['slug'])->first();

        // Создаём пользователя
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'country' => $validated['country'],
            'city' => $validated['city'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'role_id' => $role->id, // ✅ присваиваем сразу
        ]);

        return redirect()->route('users.index')->with('success', 'Пользователь успешно создан.');
    }

    public function edit($id)
    {
        // Находим пользователя
        $user = User::findOrFail($id);
        // Если нужно получить роли для выпадающего списка
        $roles = Role::all(); // или Spatie roles, или твоя модель ролей
        // Заголовок страницы
        $pageTitle = 'Редактирование пользователя ' . ': ' . $user->name; // или просто 'Редактирование пользователя'
        
        // Кнопки на странице
        $buttons = [
            [
                'href' => route('users.index'), // Должен быть маршрут users.index
                'label' => '', // Текст для перевода
                'class' => 'btn btn-secondary'
            ],
        ];
        return view('user.edit', compact('pageTitle', 'buttons', 'user', 'roles'));
    }

    public function update(Request $request, $id)
    {

        $user = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'country' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|string|max:255',
        ]);
        
        $user->update($request->only(['name', 'email', 'country', 'city', 'phone','avatar']));
        
        return redirect()
            ->route('users.index')
            ->with('success', 'Пользователь обновлен!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
    
        return redirect()->route('users.index')->with('success', 'Пользователь успешно удалён.');
    }
}
