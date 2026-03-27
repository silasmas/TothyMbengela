<?php

namespace Database\Factories;

use App\Models\Rubrique;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Rubrique>
 */
class RubriqueFactory extends Factory
{
    protected $model = Rubrique::class;

    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);

        return [
            'name' => ucfirst($name),
            'slug' => Str::slug($name).'-'.fake()->unique()->numerify('###'),
            'description' => fake()->optional(0.7)->paragraph(),
            'icon' => null,
            'thumbnail_path' => null,
            'sort_order' => fake()->numberBetween(0, 100),
            'is_active' => true,
        ];
    }
}
