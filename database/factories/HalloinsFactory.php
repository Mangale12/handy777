<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class HalloinsFactory extends Factory
{
    protected $model = \App\Models\Halloin::class;

    public function definition()
    {
        return [
            'full_name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
        ];
    }
}
