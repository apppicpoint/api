<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

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
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('roles')->insert([
            'name' => 'premium',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('roles')->insert([
            'name' => 'standard',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('roles')->insert([
            'name' => 'visitor',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('users')->insert([
            'name' => 'David',
            'nickname' => 'David',
            'email' => 'david.tejedor@outlook.com',
            'password' => Hash::make("davidadmin"),
            'role_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('users')->insert([
            'name' => 'Picpoint',
            'nickname' => 'Picpoint',
            'email' => 'apppicpoint@gmail.com',
            'password' => Hash::make("PicPoint2019"),
            'role_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('users')->insert([
            'name' => 'Carlos',
            'nickname' => 'daxter9397',
            'email' => 'carlosfdez201297@gmail.com',
            'password' => Hash::make("daxter9397"),
            'role_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('users')->insert([
            'name' => 'Sofía',
            'nickname' => 'sofiasantos',
            'email' => 'sofiasantosmelian@gmail.com',
            'password' => Hash::make("tictoctictoc"),
            'role_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('users')->insert([
            'name' => 'Joaquín',
            'nickname' => 'joaquin',
            'email' => 'joaquincollazoruiz@gmail.com',
            'password' => Hash::make("joaqin99"),
            'role_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('users')->insert([
            'name' => 'Oliver',
            'nickname' => 'oliverpk',
            'email' => 'oliverikx@hotmail.com',
            'password' => Hash::make("0l1x1234"),
            'role_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
    
}
