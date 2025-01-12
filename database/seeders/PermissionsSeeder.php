<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // Права для Компании
            [
                'uuid' => Uuid::uuid4(),
                'name' => 'Создать компанию',
                'slug' => 'create-company',
                'description' => 'Разрешение на создание новой компании в системе.'
            ],
            [
                'uuid' => Uuid::uuid4(),
                'name' => 'Просмотреть компанию',
                'slug' => 'view-company',
                'description' => 'Разрешение на просмотр информации о компании.'
            ],
            [
                'uuid' => Uuid::uuid4(),
                'name' => 'Обновить компанию',
                'slug' => 'update-company',
                'description' => 'Разрешение на редактирование данных компании.'
            ],
            [
                'uuid' => Uuid::uuid4(),
                'name' => 'Удалить компанию',
                'slug' => 'delete-company',
                'description' => 'Разрешение на удаление компании из системы.'
            ],

            // Права для Профилей
            [
                'uuid' => Uuid::uuid4(),
                'name' => 'Создать профиль',
                'slug' => 'create-profile',
                'description' => 'Разрешение на создание нового профиля пользователя.'
            ],
            [
                'uuid' => Uuid::uuid4(),
                'name' => 'Просмотреть профиль',
                'slug' => 'view-profile',
                'description' => 'Разрешение на просмотр профиля пользователя.'
            ],
            [
                'uuid' => Uuid::uuid4(),
                'name' => 'Обновить профиль',
                'slug' => 'update-profile',
                'description' => 'Разрешение на редактирование профиля пользователя.'
            ],
            [
                'uuid' => Uuid::uuid4(),
                'name' => 'Удалить профиль',
                'slug' => 'delete-profile',
                'description' => 'Разрешение на удаление профиля пользователя.'
            ],

            // Права для Департаментов
            [
                'uuid' => Uuid::uuid4(),
                'name' => 'Создать департамент',
                'slug' => 'create-department',
                'description' => 'Разрешение на создание нового департамента в организации.'
            ],
            [
                'uuid' => Uuid::uuid4(),
                'name' => 'Просмотреть департамент',
                'slug' => 'view-department',
                'description' => 'Разрешение на просмотр информации о департаменте.'
            ],
            [
                'uuid' => Uuid::uuid4(),
                'name' => 'Обновить департамент',
                'slug' => 'update-department',
                'description' => 'Разрешение на редактирование данных департамента.'
            ],
            [
                'uuid' => Uuid::uuid4(),
                'name' => 'Удалить департамент',
                'slug' => 'delete-department',
                'description' => 'Разрешение на удаление департамента из системы.'
            ],

            // Права для Ролей
            [
                'uuid' => Uuid::uuid4(),
                'name' => 'Создать роль',
                'slug' => 'create-role',
                'description' => 'Разрешение на создание новой роли для пользователей.'
            ],
            [
                'uuid' => Uuid::uuid4(),
                'name' => 'Просмотреть роль',
                'slug' => 'view-role',
                'description' => 'Разрешение на просмотр информации о роли.'
            ],
            [
                'uuid' => Uuid::uuid4(),
                'name' => 'Обновить роль',
                'slug' => 'update-role',
                'description' => 'Разрешение на редактирование данных роли.'
            ],
            [
                'uuid' => Uuid::uuid4(),
                'name' => 'Удалить роль',
                'slug' => 'delete-role',
                'description' => 'Разрешение на удаление роли из системы.'
            ],
        ];

        foreach ($permissions as $permission) {
            DB::table('permissions')->insertOrIgnore($permission);
        }
    }
}
