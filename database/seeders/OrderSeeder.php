<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::factory()
            ->count(30)
            ->create()
            ->each(function ($order) {
                // Для каждого заказа создаем один элемент заказа
                $orderItem = OrderItem::factory()->create([
                    'order_id' => $order->id,
                ]);

                // Обновляем итоговую сумму заказа
                $order->update([
                    'total_price' => $orderItem->price * $orderItem->quantity
                ]);
            });
    }
}
