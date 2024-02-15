<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use DateInterval;

class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $datetime = $this->faker->dateTimeBetween($startDate = '-1week', $endDate = '+1 week');

        $work_end = clone $datetime;
        $rand = rand(1,3);
        if($rand === 1){
            $work_end->modify('6 hour');
        }
        elseif ($rand === 2) {
            $work_end->modify('7 hour');
        }
        else{
            $work_end->modify('8 hour');
        }

        return [
            'user_id' => $this->faker->numberBetween(1,5),
            'status' => 2,
            'date' => $datetime,
            'work_start' => $datetime,
            'work_end' => $work_end,
            'created_at' => $datetime,
            'updated_at' => $work_end,
        ];
    }
}
