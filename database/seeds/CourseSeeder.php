<?php

use App\Models\Course;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $titles = [
            'PHP Developer',
            'JAVA Developer',
            'NODEJS Laravel Developer',
            'PYTHON Laravel Developer',
        ];

        $datas = [];

        foreach ($titles as $title) {
            $datas[] = [
                'title' => $title,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        }

        Course::insert($datas);
    }
}
