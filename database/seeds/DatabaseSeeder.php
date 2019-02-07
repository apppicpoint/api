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
            'name' => 'Moncloa',
            'description' => 'Zona en la que hacer fotos muy bonitas',
            'latitude' => 40.434922,
            'longitude' => -3.717887,
            'city' => 'Madrid',
            'country' => 'Spain',
            'image' => 'imagen',
            'user_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
         DB::table('spots')->insert([
            'name' => 'Bernabeu',
            'description' => 'Mejor estadio del mundo',
            'latitude' => 40.453127,
            'longitude' => -3.689621,
            'city' => 'Madrid',
            'country' => 'Spain',
            'image' => 'imagen',
            'user_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
         DB::table('spots')->insert([
            'name' => 'Playa de Gandia',
            'description' => 'Bonito lugar para hacer fotos al atardecer',
            'latitude' => 38.980989,
            'longitude' => -0.145580,
            'city' => 'Valencia',
            'country' => 'Spain',
            'image' => 'imagen',
            'user_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
         DB::table('spots')->insert([
            'name' => 'Calle san antón',
            'description' => 'Lugar perfecto para hacer fotos al paisaje',
            'latitude' => 36.724573,
            'longitude' => -4.439289,
            'city' => 'Málaga',
            'country' => 'Spain',
            'image' => 'imagen',
            'user_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
         DB::table('spots')->insert([
            'name' => 'Calle del decreto',
            'description' => 'Este sitio es perfecto para hacer fotos de fiestas andaluzas',
            'latitude' => 37.388167,
            'longitude' => -5.987326,
            'city' => 'Sevilla',
            'country' => 'Spain',
            'image' => 'imagen',
            'user_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
         DB::table('spots')->insert([
            'name' => 'Calle Madrid',
            'description' => 'Lugar perfecto para fotografiar calles llenas de encanto',
            'latitude' => 40.309002,
            'longitude' => -3.730108,
            'city' => 'Madrid',
            'country' => 'Spain',
            'image' => 'imagen',
            'user_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
          DB::table('spots')->insert([
            'name' => 'Calle del castillo',
            'description' => 'Lugar perfecto para fotografiar el castillo',
            'latitude' => 39.863500,
            'longitude' => -4.033077,
            'city' => 'Madrid',
            'country' => 'Spain',
            'image' => 'imagen',
            'user_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
           DB::table('spots')->insert([
            'name' => 'Pais de yt',
            'description' => 'Lugar perfecto para fotografiar tanto paisajes como cochazos',
            'latitude' => 42.555774,
            'longitude' => 1.564307,
            'city' => 'Andorra',
            'country' => 'Andorra',
            'image' => 'imagen',
            'user_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
            DB::table('spots')->insert([
            'name' => 'Torre eiffel',
            'description' => 'Contrucción perfecta para fotografiar',
            'latitude' => 48.873520,
            'longitude' => 2.274273,
            'city' => 'París',
            'country' => 'Francia',
            'image' => 'imagen',
            'user_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
    
}
