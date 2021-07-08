<?php

use Illuminate\Database\Seeder;
use StartTimeSeeder;
use DurationSeeder;
use CourseSeeder;
use LearningHourSeeder;
use UserSeeder;

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
            StartTimeSeeder::class,
            DurationSeeder::class,
            CourseSeeder::class,
            LearningHourSeeder::class,
            UserSeeder::class
        ]);
    }
}
