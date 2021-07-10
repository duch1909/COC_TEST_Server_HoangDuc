<?php

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
        $this->call([
            \StartTimeSeeder::class,
            \DurationSeeder::class,
            \CourseSeeder::class,
            \LearningHourSeeder::class,
            \UserSeeder::class
        ]);
    }
}
