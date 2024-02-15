<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use DateInterval;

class RestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $datetime = $this->faker->dateTimeBetween($startDate = '-1week', $endDate = '+1 week');

        $break_end = clone $datetime;
        $rand = rand(1,3);
        if($rand === 1){
            $break_end->modify('3 minute');
        }
        elseif ($rand === 2) {
            $break_end->modify('15 minute');
        }
        else{
            $break_end->modify('30 minute');
        }

        return [
            'attendance_id' => $this->faker->numberBetween(1,50),
            'break_start' => $datetime->format('H:i:s'),
            'break_end' => $break_end->format('H:i:s'),
            'created_at' => $datetime,
            'updated_at' => $datetime,
        ];
    }
}
