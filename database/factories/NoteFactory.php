<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Note>
 */
class NoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // return [
        //     'user_id' => User::all()->random()->id,
        //     'title' => $this->faker->unique()->sentence,
        //     'description' => $this->faker->paragraph,
        //     'isFavorite' => $this->faker->boolean,
        // ];
        return [
            'user_id' => User::where('id', 2)->first()->id,
            'title' => $this->faker->unique()->sentence,
            'description' => $this->faker->paragraph,
            'isFavorite' => $this->faker->boolean,
        ];
    }
}