<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'title' => fake()->sentence(3),
            'path' => 'gallery/'.Str::uuid().'.jpg',
            'mime' => 'image/jpeg',
            'size' => fake()->numberBetween(1024, 500000),
        ];
    }
}
