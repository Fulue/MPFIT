<?php

namespace App\Services;

use App\Contracts\Repositories\OrderRepositoryInterface;
use App\Contracts\Services\OrderServiceInterface;
use App\DTO\OrderDTO;
use App\DTO\OrderItemDTO;
use App\Models\Order;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderService implements OrderServiceInterface
{
    private OrderRepositoryInterface $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function getOrders(string $sortBy, string $sortDirection, ?string $statusFilter = null): LengthAwarePaginator
    {
        return $this->orderRepository->getPaginatedOrders($sortBy, $sortDirection, $statusFilter);
    }

    /**
     * @throws Exception
     */
    public function createOrder(OrderDTO $orderDTO, OrderItemDTO $orderItemDTO): OrderDTO
    {
        try {
            DB::beginTransaction();

            $order = $this->orderRepository->createOrder(
                $orderDTO->toArray(),
                $orderItemDTO->toArray()
            );

            DB::commit();

            return new OrderDTO(
                $order->customer_name,
                $order->created_date,
                $order->total_price,
                $order->comment,
                $order->status,
                $order->id
            );
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Ошибка при создании заказа: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getOrder(int $orderId): ?OrderDTO
    {
        $order = $this->orderRepository->getOrderWithRelations($orderId);

        if (!$order) {
            return null;
        }

        return new OrderDTO(
            $order->customer_name,
            $order->created_date,
            $order->total_price,
            $order->comment,
            $order->status,
            $order->id
        );
    }

    /**
     * @throws Exception
     */
    public function completeOrder(int $orderId): bool
    {
        try {
            $order = $this->orderRepository->getOrderWithRelations($orderId);

            if (!$order || $order->status !== Order::STATUS_NEW) {
                return false;
            }

            $result = $this->orderRepository->completeOrder($order);

            return $result;
        } catch (Exception $e) {
            Log::error('Ошибка при изменении статуса заказа: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * @throws Exception
     */
    public function deleteOrder(int $orderId): bool
    {
        try {
            return $this->orderRepository->deleteOrder($orderId);
        } catch (Exception $e) {
            Log::error('Ошибка при удалении заказа: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getProductsForSelect(): array
    {
        return $this->orderRepository->getProductsForSelect();
    }
}
