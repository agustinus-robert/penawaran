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
        $admin = DB::table('users')->insert([
            'name' => 'Administrator',
            'email' => 'admin@penawaran.com',
            'password' => bcrypt('penawaran'),
            'email_verified_at' => date('Y:m:d H:i:s')
        ]);

        $admin->assignRole('admin');
    }
}
