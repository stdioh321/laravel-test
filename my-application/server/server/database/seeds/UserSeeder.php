<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'test';
        $user->user = 'test';
        $user->email = 'test@gmail.com';
        $user->password = Hash::make('stdioh');
        $user->save();
        // DB::table('users')->insert([
        //     'name' => 'test',
        //     'email' => 'test@gmail.com',
        //     'password' => Hash::make('stdioh')
        // ]);
    }
}
