<?php

namespace Database\Seeders;

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
        $this->call(TaskStatusesSeeder::class);
        $this->call(CategoryWorksSeeder::class);
        $this->call(EmploymentTypesSeeder::class);
        $this->call(MediaTypesSeeder::class);
        $this->call(UserTypesSeeder::class);
        $this->call(UserSeeder::class);
    }
}
