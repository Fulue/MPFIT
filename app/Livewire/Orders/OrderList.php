<?php

namespace App\Livewire\Orders;

use App\Contracts\Services\OrderServiceInterface;
use Flux\Flux;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class OrderList extends Component
{
    use WithPagination;

    private OrderServiceInterface $orderService;

    public string $sortBy = 'created_date';
    public string $sortDirection = 'desc';
    public ?string $statusFilter = null;

    public function boot(OrderServiceInterface $orderService): void
    {
        $this->orderService = $orderService;
    }

    #[On('order-created')]
    #[On('order-updated')]
    #[On('order-deleted')]
    #[On('order-status-changed')]
    public function refreshOrders(): void
    {
        $this->resetPage();
    }

    public function sort($column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    public function filterByStatus(?string $status): void
    {
        $this->statusFilter = $status;
        $this->resetPage();
    }

    #[Computed]
    public function orders(): LengthAwarePaginator
    {
        return $this->orderService->getOrders(
            $this->sortBy,
            $this->sortDirection,
            $this->statusFilter
        );
    }

    public function deleteOrder(int $orderId): void
    {
        try {
            $result = $this->orderService->deleteOrder($orderId);

            if ($result) {
                Flux::toast(variant: 'success', text: "Заказ №{$orderId} успешно удален.");
                $this->dispatch('order-deleted');
            } else {
                Flux::toast(variant: 'danger', text: "Заказ не найден.");
            }
        } catch (\Exception $e) {
            Flux::toast(variant: 'danger', text: "Ошибка при удалении заказа: " . $e->getMessage());
        }
    }

    public function completeOrder(int $orderId): void
    {
        try {
            $result = $this->orderService->completeOrder($orderId);

            if ($result) {
                Flux::toast(variant: 'success', text: "Заказ №{$orderId} отмечен как выполненный.");
                $this->dispatch('order-status-changed');
            } else {
                Flux::toast(variant: 'warning', text: "Невозможно изменить статус заказа.");
            }
        } catch (\Exception $e) {
            Flux::toast(variant: 'danger', text: "Ошибка при изменении статуса заказа: " . $e->getMessage());
        }
    }

    public function render(): View
    {
        return view('livewire.orders.order-list');
    }
}
