<?php

namespace Database\Seeders;

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
        User::factory()
            ->count(15)
            ->create();
        $this->command->info('Table Users has been fulfilled');

        $this->call(UserDetailsTableSeeder::class);
        $this->command->info('Table User_Details has been fulfilled');
    }
}
