<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            'officer',
            'nurse',
            'gp_md',
            'er_md',
        ];

        $password = Hash::make('11111111');

        foreach($users as $user) {
            $user = User::create([
                        'name' => $user,
                        'email' => $user.'@med.si',
                        'password' => $password,
                    ]);

            $user->assignRole($user);
        }
    }
}
