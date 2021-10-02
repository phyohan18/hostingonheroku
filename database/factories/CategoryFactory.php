<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'is_publish' => $this->faker->boolean(),
            'category_photo'=> $this->faker->image('public/image/photo',640,480, null, false),
            'category_icon'=> $this->faker->image('public/image/icon',640,480, null, false),
        ];
    }
}
