<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            KundenSeeder::class,
        ]);

        $user = DB::table('users')->insert([
            'role_id' => 1,
            'created_by' => 1,
            'direktor' => 1,
            'first_name' => 'admin',
            'ip_address' => '',
            'last_name' => 'admin',
            'phone_number' => '1234',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('Asd123123'),
            'status' => Carbon::now(),
            'virtual' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $adminRole = DB::table('model_has_roles')->insert([
            'role_id' => 1,
            'model_type' => 'App\User',
            'model_id' => 1
        ]);
        $user = DB::table('users')->insert([
            'role_id' => 9,
            'created_by' => 1,
            'direktor' => 1,
            'first_name' => 'CC Admin',
            'ip_address' => '',
            'last_name' => 'CC Admin',
            'phone_number' => '1234',
            'email' => 'ccadmin',
            'password' => bcrypt('Asd123123'),
            'status' => Carbon::now(),
            'virtual' => 1,
            'country' => 'Call Center',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $adminRole = DB::table('model_has_roles')->insert([
            'role_id' => 9,
            'model_type' => 'App\User',
            'model_id' => 2
        ]);
        $user = DB::table('users')->insert([
            'role_id' => 10,
            'created_by' => 1,
            'direktor' => 1,
            'first_name' => 'BR Admin',
            'ip_address' => '',
            'last_name' => 'BR Admin',
            'phone_number' => '1234',
            'email' => 'bradmin',
            'password' => bcrypt('Asd123123'),
            'status' => Carbon::now(),
            'virtual' => 1,
            'country' => 'Broker',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $adminRole = DB::table('model_has_roles')->insert([
            'role_id' => 10,
            'model_type' => 'App\User',
            'model_id' => 3
        ]);
        $user = DB::table('users')->insert([
            'role_id' => 2,
            'created_by' => 2,
            'direktor' => 2,
            'first_name' => 'CC Direktor',
            'ip_address' => '',
            'last_name' => 'CC Direktor',
            'phone_number' => '1234',
            'email' => 'ccdirektor',
            'password' => bcrypt('Asd123123'),
            'status' => Carbon::now(),
            'virtual' => 1,
            'country' => 'Call Center',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $adminRole = DB::table('model_has_roles')->insert([
            'role_id' => 2,
            'model_type' => 'App\User',
            'model_id' => 4
        ]);
        $user = DB::table('users')->insert([
            'role_id' => 3,
            'created_by' => 3,
            'direktor' => 3,
            'first_name' => 'BR Direktor',
            'ip_address' => '',
            'last_name' => 'BR Direktor',
            'phone_number' => '1234',
            'email' => 'brdirektor',
            'password' => bcrypt('Asd123123'),
            'status' => Carbon::now(),
            'virtual' => 1,
            'country' => 'Broker',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $adminRole = DB::table('model_has_roles')->insert([
            'role_id' => 3,
            'model_type' => 'App\User',
            'model_id' => 5
        ]);
        $user = DB::table('users')->insert([
            'role_id' => 4,
            'created_by' => 4,
            'direktor' => 4,
            'first_name' => 'CCT Leader',
            'ip_address' => '',
            'last_name' => 'CCT Leader',
            'phone_number' => '1234',
            'email' => 'cctleader',
            'password' => bcrypt('Asd123123'),
            'status' => Carbon::now(),
            'virtual' => 1,
            'country' => 'Call Center',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $adminRole = DB::table('model_has_roles')->insert([
            'role_id' => 4,
            'model_type' => 'App\User',
            'model_id' => 6
        ]);
        $user = DB::table('users')->insert([
            'role_id' => 5,
            'created_by' => 4,
            'direktor' => 4,
            'quality_responsibility' => 'all',
            'first_name' => 'CC QC',
            'ip_address' => '',
            'last_name' => 'CC QC',
            'phone_number' => '1234',
            'email' => 'ccqc',
            'password' => bcrypt('Asd123123'),
            'status' => Carbon::now(),
            'virtual' => 1,
            'country' => 'Call Center',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $adminRole = DB::table('model_has_roles')->insert([
            'role_id' => 5,
            'model_type' => 'App\User',
            'model_id' => 7
        ]);
        $user = DB::table('users')->insert([
            'role_id' => 6,
            'created_by' => 5,
            'direktor' => 5,
            'first_name' => 'BRT Leader',
            'ip_address' => '',
            'last_name' => 'BRT Leader',
            'phone_number' => '1234',
            'email' => 'brtleader',
            'password' => bcrypt('Asd123123'),
            'status' => Carbon::now(),
            'virtual' => 1,
            'country' => 'Broker',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $adminRole = DB::table('model_has_roles')->insert([
            'role_id' => 6,
            'model_type' => 'App\User',
            'model_id' => 8
        ]);
        $user = DB::table('users')->insert([
            'role_id' => 7,
            'created_by' => 6,
            'direktor' => 4,
            'first_name' => 'CC Agent',
            'ip_address' => '',
            'last_name' => 'CC Agent',
            'phone_number' => '1234',
            'email' => 'ccagent',
            'password' => bcrypt('Asd123123'),
            'status' => Carbon::now(),
            'virtual' => 1,
            'country' => 'Call Center',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $adminRole = DB::table('model_has_roles')->insert([
            'role_id' => 7,
            'model_type' => 'App\User',
            'model_id' => 9
        ]);
        $user = DB::table('users')->insert([
            'role_id' => 8,
            'created_by' => 8,
            'direktor' => 5,
            'first_name' => 'BR Berater',
            'ip_address' => '',
            'last_name' => 'BR Berater',
            'phone_number' => '1234',
            'email' => 'brberater',
            'password' => bcrypt('Asd123123'),
            'status' => Carbon::now(),
            'virtual' => 1,
            'country' => 'Broker',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $adminRole = DB::table('model_has_roles')->insert([
            'role_id' => 8,
            'model_type' => 'App\User',
            'model_id' => 10
        ]);

        $time = DB::table('appointment_time_filters')->insert([
            'filter_by' => null,
            'from' => null,
            'to' => null
        ]);

    }
}
