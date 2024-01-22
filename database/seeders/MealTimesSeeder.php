<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MealTimesSeeder extends Seeder
{
/**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mealTimes = [
            [
                'meal_type' => 'Breakfast',
                'start_time' => '08:00:00',
                'end_time' => '09:00:00',
            ],
            [
                'meal_type' => 'Lunch',
                'start_time' => '12:00:00',
                'end_time' => '13:00:00',
            ],
            [
                'meal_type' => 'Dinner',
                'start_time' => '18:00:00',
                'end_time' => '19:00:00',
            ],
            // Add more meal times as needed
        ];

        // Insert data into the meal_times table
        DB::table('meal_times')->insert($mealTimes);
    }
}
