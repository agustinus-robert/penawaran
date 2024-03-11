<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@penawaran.com',
            'password' => bcrypt('penawaran'),
            'email_verified_at' => date('Y:m:d H:i:s')
        ]);

        $admin->assignRole('admin');

        $client = User::create([
            'name' => 'Client',
            'email' => 'client@penawaran.com',
            'password' => bcrypt('penawaran'),
            'email_verified_at' => date('Y:m:d H:i:s')
        ]);

        $client->assignRole('client');

        DB::table('client')->insert([
            'user_id' => $client->id, 
            'nama' => 'Client', 
            'email' => 'client@penawaran.com', 
            'created_by' => 1, 
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $perusahaan = User::create([
            'name' => 'Perusahaan',
            'email' => 'perusahaan@penawaran.com',
            'password' => bcrypt('penawaran'),
            'email_verified_at' => date('Y:m:d H:i:s')
        ]);

        $perusahaan->assignRole('perusahaan');

        DB::table('ref_perusahaan')->insert([
            'user_id' => $perusahaan->id, 
            'nama' => 'Perusahaan', 
            'email' => 'perusahaan@penawaran.com', 
            'created_by' => 1, 
            'created_at' => date('Y-m-d H:i:s')
        ]);

    }
}
