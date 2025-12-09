<?php
// database/seeders/RoleSeeder.php
namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'name' => 'Super Admin',
                'slug' => 'super_admin',
                'permissions' => ['*' => ['*']],
                'description' => 'Полный доступ ко всем функциям системы',
                'is_system' => true
            ],
            [
                'name' => 'Admin',
                'slug' => 'admin',
                'permissions' => [
                    'admin' => ['access'],
                    'users' => ['create', 'read', 'update', 'delete'],
                    'content' => ['*'],
                    'settings' => ['read', 'update'],
                    'roles' => ['create', 'read', 'update', 'delete'] // ← ДОБАВИЛ ПРАВА ДЛЯ РОЛЕЙ
                ],
                'description' => 'Администратор системы',
                'is_system' => true
            ],
            [
                'name' => 'User',
                'slug' => 'user',
                'permissions' => [
                    'profile' => ['read', 'update']
                ],
                'description' => 'Зарегистрированный пользователь',
                'is_system' => true
            ]
        ];

        foreach ($roles as $roleData) {
            Role::create($roleData);
        }
    }
}