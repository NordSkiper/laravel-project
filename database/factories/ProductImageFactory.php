<?php

namespace Database\Factories;

use App\Models\Model;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductImageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductImage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

//        dd($this->faker->image(storage_path('images/products'), 400, 600));
        return [
            'path' => $this->faker->image(storage_path('images/products'), 400, 600)
        ];
    }
}
