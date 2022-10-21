<?php

namespace Database\Factories;

use App\Models\Developer;
use App\Models\Level;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Developers\Developer>
 */
class DeveloperFactory extends Factory
{
    protected $model = Developer::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'level_id' => $this->faker->numberBetween(1, Level::count()),
            'name' => $this->faker->name,
            'gender' => $this->faker->randomElement(['m', 'f']),
            'birth_date' => $this->faker->date,
            'age' => $this->faker->numberBetween(15, 55),
            'hobby' => $this->faker->text(120)
        ];
    }
}
