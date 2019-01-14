<?php

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
       	DB::table('roles')->insert([
            'name' => 'admin',
        ]);

        DB::table('roles')->insert([
            'name' => 'premium',
        ]);
        DB::table('roles')->insert([
            'name' => 'standard',
        ]);
        DB::table('roles')->insert([
            'name' => 'visitor',
        ]);

        DB::table('users')->insert([
            'name' => 'David',
            'nickname' => 'David',
            'email' => 'david.tejedor@outlook.com',
            'password' => Hash::make("davidadmin"),
            'role_id' => 1,
        ]);
        DB::table('users')->insert([
            'name' => 'Picpoint',
            'nickname' => 'Picpoint',
            'email' => 'apppicpoint@gmail.com',
            'password' => Hash::make("PicPoint2019"),
            'role_id' => 1,
        ]);
        DB::table('users')->insert([
            'name' => 'Carlos',
            'nickname' => 'daxter9397',
            'email' => 'carlosfdez201297@gmail.com',
            'password' => Hash::make("daxter9397"),
            'role_id' => 1,
        ]);
        DB::table('users')->insert([
            'name' => 'Sofía',
            'nickname' => 'sofiasantos',
            'email' => 'sofiasantosmelian@gmail.com',
            'password' => Hash::make("tictoctictoc"),
            'role_id' => 1,
        ]);
        DB::table('users')->insert([
            'name' => 'Joaquín',
            'nickname' => 'joaquin',
            'email' => 'joaquincollazoruiz@gmail.com',
            'password' => Hash::make("joaqin99"),
            'role_id' => 1,
        ]);
        DB::table('users')->insert([
            'name' => 'Oliver',
            'nickname' => 'oliverpk',
            'email' => 'oliverkx@hotmail.com',
            'password' => Hash::make("oliver123"),
            'role_id' => 1,
        ]);
    }
    
}
