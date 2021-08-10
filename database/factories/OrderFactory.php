<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'branch_id' => rand(1,12),
            'user_id' => rand(1,12),
            'code' => Str::random(10),
            'status' => 'PENDING',
            'description' => Str::random(60),
            'bruto' => rand(100000,1000000),
            'diskon' => rand(0,100),
            'hdkp' => rand(10000,100000),
            'tax' => rand(10000,100000),
            'netto' => rand(10000,100000),
        ];
    }
}
