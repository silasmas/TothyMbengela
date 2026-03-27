<?php

namespace Database\Factories;

use App\Models\Rubrique;
use App\Models\Series;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Series>
 */
class SeriesFactory extends Factory
{
    protected $model = Series::class;

    public function definition(): array
    {
        $title = fake()->unique()->sentence(3);

        return [
            'rubrique_id' => Rubrique::factory(),
            'theme_id' => null,
            'title' => rtrim($title, '.'),
            'slug' => Str::slug($title).'-'.fake()->unique()->numerify('##'),
            'icon' => null,
            'thumbnail_path' => null,
            'description' => fake()->optional(0.6)->paragraph(),
            'sort_order' => fake()->numberBetween(0, 50),
        ];
    }

    public function forRubrique(Rubrique $rubrique): static
    {
        return $this->state(fn (array $attributes) => [
            'rubrique_id' => $rubrique->id,
        ]);
    }
}
