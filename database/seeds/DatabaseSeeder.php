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
        User::create([
            'name' => 'Shahrooz',
            'email' => 'shahrooz.nld@gmail.com',
            'email_verified_at' => now(),
            'password' =>  Hash::make('password'),

        ]);



    }
}
