<?php

namespace Database\Factories;

use App\Models\Todolist;
use Illuminate\Database\Eloquent\Factories\Factory;

class TodolistFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Todolist::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'set_time' => $this->faker->time('H:i'),
            'task' => $this->faker->word
        ];
    }
}
