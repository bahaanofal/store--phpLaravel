<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $name = $this->faker->words(2, true);

        $result = Category::inRandomOrder()->limit(1)->first(['id']);

        $status = ['active', 'draft'];
        
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'category_id' => $result ? $result->id : null,
            'description' => $this->faker->words(200, true),
            'image_path' => $this->faker->imageUrl(),
            'status' => $status[rand(0, 1)],
            'price' => $this->faker->randomFloat(2, 50, 2000),
            'quantity' => $this->faker->randomFloat(0, 0, 30)
        ];

    }
}
