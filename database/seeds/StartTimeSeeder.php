<?php

use App\Models\StartTime;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class StartTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $startTimes = [];

        for ($i = 1; $i <= 24; $i++) {
            $startTimes[] = [
                'start_time' => Carbon::createFromTime($i),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        }

        StartTime::insert($startTimes);
    }
}
