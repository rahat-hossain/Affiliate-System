<?php

use App\User;
use Illuminate\Database\Seeder;

class CreateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'phone' => '01521414629',
                'type' => 'admin',
                'password' => bcrypt('admin'),
                'refrrel_token' => \Illuminate\Support\Str::random(6),
            ],

            [
                'name' => 'user',
                'email' => 'user@gmail.com',
                'phone' => '01685853133',
                'type' => 'user',
                'password' => bcrypt('user'),
                'refrrel_token' => \Illuminate\Support\Str::random(6),
            ],
        ];

        foreach ($user as $key => $value)
        {
            User::create($value);
        }

    }
}
