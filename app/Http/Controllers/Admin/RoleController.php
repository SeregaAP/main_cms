<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::withCount('users')->get();
        $pageTitle = 'Управление ролями';
        $buttons = [
            [
                'href'  => route('roles.create'),
                'label' => 'Создать роль',
                'class' => 'btn btn-secondary'
            ]
        ];
    
        return view('admin.roles.index', compact('roles','pageTitle', 'buttons'));
    }

    public function create()
    {
        $pageTitle = 'Создание роли';
        $buttons = [
            [
                'href'  => route('roles.index'),
                'label' => 'Все роли',
                'class' => 'btn btn-secondary'
            ]
        ];
        $availablePermissions = [
            'admin' => ['access' => 'Доступ в админку'],
            'users' => [
                'create' => 'Создание пользователей',
                'read' => 'Просмотр пользователей', 
                'update' => 'Редактирование пользователей',
                'delete' => 'Удаление пользователей'
            ],
            'content' => [
                '*' => 'Полный доступ к контенту',
                'create' => 'Создание контента',
                'read' => 'Просмотр контента',
                'update' => 'Редактирование контента',
                'delete' => 'Удаление контента',
                'publish' => 'Публикация контента'
            ],
            'settings' => [
                'read' => 'Просмотр настроек',
                'update' => 'Изменение настроек'
            ],
            'roles' => [
                'create' => 'Создание ролей',
                'read' => 'Просмотр ролей',
                'update' => 'Редактирование ролей', 
                'delete' => 'Удаление ролей'
            ],
            'template' => [
                'create' => 'Создание шаблонов',
                'read' => 'Просмотр шаблонов',
                'update' => 'Редактирование шаблонов', 
                'delete' => 'Удаление шаблонов'
            ],
            'chunk' => [
                'create' => 'Создание чанков',
                'read' => 'Просмотр чанков',
                'update' => 'Редактирование чанков', 
                'delete' => 'Удаление чанков'
            ],
            'tvs' => [
                'create' => 'Создание tv',
                'read' => 'Просмотр tv',
                'update' => 'Редактирование tv', 
                'delete' => 'Удаление tv'
            ]
        ];

        return view('admin.roles.create', compact('availablePermissions','pageTitle', 'buttons'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles|max:255',
            'slug' => 'required|unique:roles|max:255',
            'description' => 'nullable|max:500'
        ]);

        // Формируем permissions из запроса
        $permissions = [];
        foreach ($request->input('permissions', []) as $resource => $actions) {
            $permissions[$resource] = is_array($actions) ? $actions : [$actions];
        }

        Role::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
            'permissions' => $permissions,
            'is_system' => false
        ]);

        return redirect()->route('roles.index')->with('success', 'Роль создана');
    }

    public function edit(Role $role)
    {
        $pageTitle = 'Редактирование роли';
        $buttons = [
            [
                'href'  => route('roles.index'),
                'label' => 'Все роли',
                'class' => 'btn btn-secondary'
            ]
        ];
        
        $availablePermissions = [
            'admin' => ['access' => 'Доступ в админку'],
            'users' => [
                'create' => 'Создание пользователей',
                'read' => 'Просмотр пользователей',
                'update' => 'Редактирование пользователей',
                'delete' => 'Удаление пользователей'
            ],
            'content' => [
                '*' => 'Полный доступ к контенту',
                'create' => 'Создание контента',
                'read' => 'Просмотр контента',
                'update' => 'Редактирование контента',
                'delete' => 'Удаление контента',
                'publish' => 'Публикация контента'
            ],
            'settings' => [
                'read' => 'Просмотр настроек',
                'update' => 'Изменение настроек'
            ],
            'roles' => [
                'create' => 'Создание ролей',
                'read' => 'Просмотр ролей',
                'update' => 'Редактирование ролей',
                'delete' => 'Удаление ролей'
            ],
            'template' => [
                'create' => 'Создание шаблонов',
                'read' => 'Просмотр шаблонов',
                'update' => 'Редактирование шаблонов', 
                'delete' => 'Удаление шаблонов'
            ],
            'chunk' => [
                'create' => 'Создание чанков',
                'read' => 'Просмотр чанков',
                'update' => 'Редактирование чанков', 
                'delete' => 'Удаление чанков'
            ],
            'tvs' => [
                'create' => 'Создание tv',
                'read' => 'Просмотр tv',
                'update' => 'Редактирование tv', 
                'delete' => 'Удаление tv'
            ]
        ];

        return view('admin.roles.edit', compact('role', 'availablePermissions','pageTitle', 'buttons'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|max:255|unique:roles,name,' . $role->id,
            'slug' => 'required|max:255|unique:roles,slug,' . $role->id,
            'description' => 'nullable|max:500'
        ]);

        // Формируем permissions из запроса
        $permissions = [];
        foreach ($request->input('permissions', []) as $resource => $actions) {
            $permissions[$resource] = is_array($actions) ? $actions : [$actions];
        }

        $role->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
            'permissions' => $permissions
        ]);

        return redirect()->route('roles.index')->with('success', 'Роль обновлена');
    }

    public function destroy(Role $role)
    {
        if ($role->is_system) {
            return redirect()->back()->with('error', 'Системные роли нельзя удалять');
        }

        if ($role->users()->exists()) {
            return redirect()->back()->with('error', 'Нельзя удалить роль, у которой есть пользователи');
        }

        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Роль удалена');
    }
}