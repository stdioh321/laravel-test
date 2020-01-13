<?php

use Illuminate\Database\Seeder;
use App\User;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = [
            'name' => 'admin',
            'email' => 'admin@email.com',
            'password' => bcrypt('123456')
        ];
        if (User::where('email', '=', $data['email'])->count()) {
            $user = User::where('email', '=', $data['email']);
            $user->update($data);
        } else {
            User::create($data);

        }
    }
}
