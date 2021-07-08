<?php

use App\Models\LearningHour;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class LearningHourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $learningHours = [];

        for ($i = 1; $i <= 6; $i++) {
            $learningHours[] = [
                'learning_hour' => Carbon::createFromTime($i),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];

            $learningHours[] = [
                'learning_hour' => Carbon::createFromTime($i, 30),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        }

        LearningHour::insert($learningHours);
    }
}
