<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

         User::factory()->create([
             'username' => '71111544',
             'name' => 'Rodrigo',
             'surname' => 'Torres',
             'status' => '1',
             'dni' => '71111544',
             'cellphone' => '964945180',
             'shift' => 'Mañana',
             'birthday' => '2023-05-16',
             'image' => 'foto.jpg',
             'date_start' => '2023-05-09',
             'date_end' => '2023-05-09',
             //'position_id' => '1',

             'email' => 'torresrodrigo752@gmail.com',
             'password' => bcrypt('71111544'),
         ]);
    }
}
