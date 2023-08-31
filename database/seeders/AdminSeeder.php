<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'first_name'=>'Admin',
            'phone'=>'+986543210',
            'password'=>'11111111',
            'role'=>0
        ]);
    }
}
