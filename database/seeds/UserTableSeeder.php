<?php

use Illuminate\Database\Seeder;
use App\User;
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       User::create([
           'name'=>'ismael',
           'email'=>'ismael@laravel.com',
           'password'=>bcrypt('ismael'),
           'reputation'=>0,
           'visits_number'=>0,
           'logo_path'=>''
       ]);
    }
}
