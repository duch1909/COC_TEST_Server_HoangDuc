<?php

use App\Models\Duration;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $months = [];

        for ($i = 1; $i <= 12; $i++) {
            $months[] = [
                'month' => $i,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        }

        Duration::insert($months);
    }
}
