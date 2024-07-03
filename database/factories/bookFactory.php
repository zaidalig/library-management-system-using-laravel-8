<?php

namespace Database\Factories;

use App\Models\book;
use App\Models\category;
use App\Models\auther;
use App\Models\publisher;
use Illuminate\Database\Eloquent\Factories\Factory;

class bookFactory extends Factory
{
    protected $model = book::class;

    public function definition()
    {
        return [
            'name' => $this->faker->sentence,
            'category_id' => category::factory(),
            'auther_id' => auther::factory(),
            'publisher_id' => publisher::factory(),
            'status' => 'Y',
        ];
    }
}
