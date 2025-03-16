<?php

namespace App\Contracts\Repositories;

use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;

interface OrderRepositoryInterface
{
    /**
     * Получить список заказов с пагинацией и сортировкой.
     *
     * @param string $sortBy
     * @param string $sortDirection
     * @param string|null $statusFilter
     * @return LengthAwarePaginator
     */
    public function getPaginatedOrders(string $sortBy, string $sortDirection, ?string $statusFilter = null): LengthAwarePaginator;

    /**
     * Создать новый заказ с элементом заказа.
     *
     * @param array $orderData
     * @param array $orderItemData
     * @return Order
     */
    public function createOrder(array $orderData, array $orderItemData): Order;

    /**
     * Получить заказ с предзагрузкой связанных данных.
     *
     * @param int $orderId
     * @return Order|null
     */
    public function getOrderWithRelations(int $orderId): ?Order;

    /**
     * Изменить статус заказа на "выполнен".
     *
     * @param Order $order
     * @return bool
     */
    public function completeOrder(Order $order): bool;

    /**
     * Удалить заказ вместе с элементами заказа.
     *
     * @param int $orderId
     * @return bool
     */
    public function deleteOrder(int $orderId): bool;

    /**
     * Получить форматированный список продуктов для выпадающего списка.
     *
     * @return array
     */
    public function getProductsForSelect(): array;
}
