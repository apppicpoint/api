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
        //Spots
         DB::table('spots')->insert([
            'name' => 'Puerta del Sol',
            'description' => 'Este sitio es perfecto para hacer fotos al amanecer',
            'latitude' => 40.417061,
            'longitude' => -3.703526,
            'city' => 'Madrid',
            'country' => 'Spain',
            'image' => 'imagen',
            'user_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
         DB::table('spots')->insert([
            'name' => 'Prueba2',
            'description' => 'Descripcion2',
            'latitude' => 40.417061,
            'longitude' => -3.703526,
            'city' => 'Madrid',
            'country' => 'Spain',
            'image' => 'imagen',
            'user_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
         DB::table('spots')->insert([
            'name' => 'Prueba3',
            'description' => 'Descripcion3',
            'latitude' => 41.437061,
            'longitude' => -3.503526,
            'city' => 'Madrid',
            'country' => 'Spain',
            'image' => 'imagen',
            'user_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
         DB::table('spots')->insert([
            'name' => 'Prueba4',
            'description' => 'Descripcion4',
            'latitude' => 39.417061,
            'longitude' => -3.793526,
            'city' => 'Madrid',
            'country' => 'Spain',
            'image' => 'imagen',
            'user_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
         DB::table('spots')->insert([
            'name' => 'Prueba5',
            'description' => 'Descripcion5',
            'latitude' => 40.987061,
            'longitude' => -3.31203526,
            'city' => 'Madrid',
            'country' => 'Spain',
            'image' => 'imagen',
            'user_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
         DB::table('spots')->insert([
            'name' => 'Prueba6',
            'description' => 'Descripcion6',
            'latitude' => 43.417061,
            'longitude' => -2.703526,
            'city' => 'Madrid',
            'country' => 'Spain',
            'image' => 'imagen',
            'user_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
         DB::table('spots')->insert([
            'name' => 'Prueba7',
            'description' => 'Descripcion7',
            'latitude' => 46.417061,
            'longitude' => -1.703526,
            'city' => 'Madrid',
            'country' => 'Spain',
            'image' => 'imagen',
            'user_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
          DB::table('spots')->insert([
            'name' => 'Prueba8',
            'description' => 'Descripcion8',
            'latitude' => 41.417061,
            'longitude' => -1.703526,
            'city' => 'Madrid',
            'country' => 'Spain',
            'image' => 'imagen',
            'user_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
           DB::table('spots')->insert([
            'name' => 'Prueba9',
            'description' => 'Descripcion9',
            'latitude' => 52.417061,
            'longitude' => -1.703526,
            'city' => 'Madrid',
            'country' => 'Spain',
            'image' => 'imagen',
            'user_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
            DB::table('spots')->insert([
            'name' => 'Prueba10',
            'description' => 'Descripcion10',
            'latitude' => 13.417061,
            'longitude' => -1.9,
            'city' => 'Madrid',
            'country' => 'Spain',
            'image' => 'imagen',
            'user_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
    
}
