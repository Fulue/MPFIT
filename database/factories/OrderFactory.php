<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends Factory<Order>
 */
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
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_name' => $this->faker->name(),
            'created_date' => Carbon::now()->subDays(rand(0, 30))->format('Y-m-d'),
            'status' => $this->faker->randomElement([Order::STATUS_NEW, Order::STATUS_COMPLETED]),
            'comment' => $this->faker->boolean(70) ? $this->faker->text(100) : null,
            'total_price' => 0,
        ];
    }
}
