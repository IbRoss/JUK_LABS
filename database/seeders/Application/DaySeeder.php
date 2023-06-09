<?php

namespace Database\Seeders\Application;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Day;
use App\Models\Group;
use App\Models\Student;
use App\Models\TimeLesson;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DaySeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $days = [
            [
                'day' => Carbon::today(),
                'week' => 1,
            ],
            [
                'day' => Carbon::today()->add(1,'day'),
                'week' => 1,
            ],
            [
                'day' => Carbon::today()->add(2,'day'),
                'week' => 1,
            ],
            [
                'day' => Carbon::today()->add(3,'day'),
                'week' => 1,
            ],
            [
                'day' => Carbon::today()->add(4,'day'),
                'week' => 1,
            ],
            [
                'day' => Carbon::today()->add(8,'day'),
                'week' => 2,
            ],
            [
                'day' => Carbon::today()->add(9,'day'),
                'week' => 2,
            ],
            [
                'day' => Carbon::today()->add(10,'day'),
                'week' => 2,
            ],
            [
                'day' => Carbon::today()->add(11,'day'),
                'week' => 2,
            ],
            [
                'day' => Carbon::today()->add(12,'day'),
                'week' => 2,
            ],
        ];

        Day::insert($days);
    }
}
