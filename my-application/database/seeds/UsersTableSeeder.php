<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create([
            "name" => "Alan",
            "email" => "alan@email.com",
            "password" => bcrypt('123456'),
            "senha" => bcrypt('123456'),
            "usuario" => 'alan'
        ]);
    }
}
