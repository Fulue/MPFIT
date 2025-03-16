<?php

namespace App\Contracts\Services;

use App\DTO\OrderDTO;
use App\DTO\OrderItemDTO;
use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;

interface OrderServiceInterface
{
    /**
     * Получить список заказов с пагинацией и фильтрацией.
     *
     * @param string $sortBy
     * @param string $sortDirection
     * @param string|null $statusFilter
     * @return LengthAwarePaginator
     */
    public function getOrders(string $sortBy, string $sortDirection, ?string $statusFilter = null): LengthAwarePaginator;

    /**
     * Создать новый заказ.
     *
     * @param OrderDTO $orderDTO
     * @param OrderItemDTO $orderItemDTO
     * @return OrderDTO
     */
    public function createOrder(OrderDTO $orderDTO, OrderItemDTO $orderItemDTO): OrderDTO;

    /**
     * Получить заказ по ID с его элементами.
     *
     * @param int $orderId
     * @return OrderDTO|null
     */
    public function getOrder(int $orderId): ?OrderDTO;

    /**
     * Изменить статус заказа на "выполнен".
     *
     * @param int $orderId
     * @return bool
     */
    public function completeOrder(int $orderId): bool;

    /**
     * Удалить заказ.
     *
     * @param int $orderId
     * @return bool
     */
    public function deleteOrder(int $orderId): bool;

    /**
     * Получить список товаров для выпадающего списка.
     *
     * @return array
     */
    public function getProductsForSelect(): array;
}
