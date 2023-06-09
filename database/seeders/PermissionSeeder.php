<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',

            'role-list',
            'role-create',
            'role-edit',
            'role-delete',

            'tour-category-list',
            'tour-category-create',
            'tour-category-edit',
            'tour-category-delete',

            'tour-list',
            'tour-create',
            'tour-edit',
            'tour-delete',

            'news-category-list',
            'news-category-create',
            'news-category-edit',
            'news-category-delete',

            'news-list',
            'news-create',
            'news-edit',
            'news-delete',

            'lodge-list',
            'lodge-create',
            'lodge-edit',
            'lodge-delete',

            'tour-package-list',
            'tour-package-create',
            'tour-package-edit',
            'tour-package-delete',

            'reservation-list',
            'reservation-create',
            'reservation-edit',
            'reservation-delete',
            'reservation-payment',
            'reservation-cancel',
            'reservation-export',

            'employee-list',
            'employee-create',
            'employee-edit',
            'employee-delete',
        ];

        foreach ($permissions as $permission) {
            \Spatie\Permission\Models\Permission::create(['name' => $permission]);
        }
    }
}
