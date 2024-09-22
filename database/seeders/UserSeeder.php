<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'qa@tester.com'],
            [
                'name' => 'QA Tester',
                'email' => 'qa@tester.com',
                'password' => bcrypt('testerpassword')
            ]
        );
    }
}
