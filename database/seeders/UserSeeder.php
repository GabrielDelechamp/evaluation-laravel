<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'first_name' => 'admin',
            'last_name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
        ]);

        User::factory(20)->create();

        DB::table('users')->insert([
            'first_name' => 'user',
            'last_name' => 'user',
            'email' => 'user@user.com',
            'password' => Hash::make('password'),
        ]);

        $user=User::find(1);
        $user->assign('admin');

        $users=User::all();
        foreach ($users as $user) {
            $user->assign('user');
        }
    }
}
