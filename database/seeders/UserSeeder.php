<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Superadmin',
            'email' => 'superadmin@test.dev',
            'password' => bcrypt('123qweasd'),
        ]);
        $user->assignRole('superadmin');

        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@test.dev',
            'password' => bcrypt('123qweasd'),
        ]);
        $user->assignRole('admin');

        $user = User::create([
            'name' => 'Treasurer',
            'email' => 'treasurer@test.dev',
            'password' => bcrypt('123qweasd'),
            'password_by_admin' => true,
        ]);
        $user->assignRole('treasurer');

        $user = User::create([
            'name' => 'owner',
            'email' => 'owner@test.dev',
            'password' => bcrypt('123qweasd'),
            'password_by_admin' => true,
        ]);
        $user->assignRole('owner');

        // Factory 30 users and assign them role as customer
        User::factory()->count(30)->create()->each(function ($user) {
            $user->assignRole('customer');
            $user->customer()->create();
        });
    }
}
