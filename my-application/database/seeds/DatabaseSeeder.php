<?php

use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $pass = bcrypt('123456');
        User::create([
            "name" => "Alan",
            "email" => "alan@email.com",
            "password" => $pass,
            "senha" => '123456',
            "usuario" => 'alan'
        ]);
    }
}
