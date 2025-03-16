<?php

namespace App\Livewire\Orders;

use App\Contracts\Services\OrderServiceInterface;
use App\Models\Order;
use Flux\Flux;
use Illuminate\View\View;
use Livewire\Component;

class OrderView extends Component
{
    private OrderServiceInterface $orderService;

    public Order $order;

    public function boot(OrderServiceInterface $orderService): void
    {
        $this->orderService = $orderService;
    }

    public function mount(Order $order): void
    {
        $loadedOrder = $this->orderService->getOrder($order->id);

        if ($loadedOrder) {
            $this->order = $order->load('orderItems.product.category');
        } else {
            $this->order = $order;
        }
    }

    public function completeOrder(): void
    {
        try {
            if ($this->order->status === Order::STATUS_NEW) {
                $result = $this->orderService->completeOrder($this->order->id);

                if ($result) {
                    // Обновляем статус локальной модели
                    $this->order->status = Order::STATUS_COMPLETED;

                    Flux::toast(variant: 'success', text: "Заказ №{$this->order->id} отмечен как выполненный.");
                    Flux::modal('view-order-' . $this->order->id)->close();
                    $this->dispatch('order-status-changed');
                } else {
                    Flux::toast(variant: 'warning', text: "Невозможно изменить статус заказа.");
                }
            }
        } catch (\Exception $e) {
            Flux::toast(variant: 'danger', text: "Ошибка при изменении статуса заказа: " . $e->getMessage());
        }
    }

    public function render(): View
    {
        return view('livewire.orders.order-view');
    }
}
