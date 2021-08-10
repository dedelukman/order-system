<?php

namespace Database\Factories;

use App\Models\OrderDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderDetailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderDetail::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'order_id' => rand(1,20),
            'product_id' => rand(1,400),
            'quantity' => rand(1,100),
            'price' => rand(10000,100000),
            'diskon' => rand(10,100),
            'total' => rand(10000,100000),           
        ];
    }
}
