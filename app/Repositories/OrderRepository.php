<?php

namespace App\Repositories;

use App\Contracts\Repositories\OrderRepositoryInterface;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

class OrderRepository implements OrderRepositoryInterface
{
    public function getPaginatedOrders(string $sortBy, string $sortDirection, ?string $statusFilter = null): LengthAwarePaginator
    {
        return Order::query()
            ->when($statusFilter, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->orderBy($sortBy, $sortDirection)
            ->paginate(10);
    }

    public function createOrder(array $orderData, array $orderItemData): Order
    {
        // Создаем заказ
        $order = Order::query()->create([
            'customer_name' => $orderData['customer_name'],
            'created_date' => $orderData['created_date'],
            'status' => Order::STATUS_NEW,
            'comment' => $orderData['comment'] ?? null,
            'total_price' => $orderData['total_price'],
        ]);

        // Создаем элемент заказа
        OrderItem::query()->create([
            'order_id' => $order->id,
            'product_id' => $orderItemData['product_id'],
            'quantity' => $orderItemData['quantity'],
            'price' => $orderItemData['price'],
        ]);

        return $order;
    }

    public function getOrderWithRelations(int $orderId): ?Order
    {
        return Order::query()->with('orderItems.product.category')
            ->find($orderId);
    }

    public function completeOrder(Order $order): bool
    {
        if ($order->status === Order::STATUS_NEW) {
            return $order->update([
                'status' => Order::STATUS_COMPLETED
            ]);
        }

        return false;
    }

    public function deleteOrder(int $orderId): bool
    {
        $order = Order::query()->find($orderId);

        if ($order) {
            // Удаляем связанные элементы заказа
            $order->orderItems()->delete();

            // Удаляем сам заказ
            $order->delete();

            return true;
        }

        return false;
    }

    public function getProductsForSelect(): array
    {
        return Product::query()
            ->orderBy('name')
            ->get()
            ->map(function ($product) {
                return [
                    'value' => $product->id,
                    'label' => "{$product->name} ({$product->price} ₽)",
                ];
            })
            ->toArray();
    }
}
