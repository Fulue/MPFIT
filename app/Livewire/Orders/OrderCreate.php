<?php

namespace App\Livewire\Orders;

use App\Contracts\Services\OrderServiceInterface;
use App\DTO\OrderDTO;
use App\DTO\OrderItemDTO;
use Carbon\Carbon;
use Flux\Flux;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Livewire\Component;

class OrderCreate extends Component
{
    private OrderServiceInterface $orderService;

    #[Validate('required', message: 'ФИО покупателя обязательно.')]
    #[Validate('min:3', message: 'ФИО должно содержать не менее 3 символов.')]
    #[Validate('max:255', message: 'ФИО не должно превышать 255 символов.')]
    public string $customer_name = '';

    #[Validate('required', message: 'Дата создания обязательна.')]
    #[Validate('date', message: 'Неверный формат даты.')]
    public string $created_date = '';

    #[Validate('nullable')]
    #[Validate('string', message: 'Комментарий должен быть текстом.')]
    public ?string $comment = '';

    #[Validate('required', message: 'Выбор товара обязателен.')]
    #[Validate('exists:products,id', message: 'Выбранный товар не существует.')]
    public ?int $product_id = null;

    #[Validate('required', message: 'Количество товара обязательно.')]
    #[Validate('integer', message: 'Количество должно быть целым числом.')]
    #[Validate('min:1', message: 'Количество должно быть не менее 1.')]
    public int $quantity = 1;

    public ?float $product_price = null;
    public float $total_price = 0;

    public function boot(OrderServiceInterface $orderService): void
    {
        $this->orderService = $orderService;
    }

    public function mount(): void
    {
        $this->created_date = Carbon::now()->format('Y-m-d');
    }

    #[Computed]
    public function products(): array
    {
        return $this->orderService->getProductsForSelect();
    }

    public function updatedProductId(): void
    {
        if ($this->product_id) {
            // Ищем цену продукта из списка продуктов
            $productsList = $this->orderService->getProductsForSelect();
            $product = collect($productsList)->firstWhere('value', $this->product_id);

            if ($product) {
                // Извлекаем цену из строки формата "Название товара (1000.00 ₽)"
                preg_match('/\(([0-9.]+) ₽\)/', $product['label'], $matches);
                $this->product_price = isset($matches[1]) ? (float) $matches[1] : null;
                $this->calculateTotal();
            }
        } else {
            $this->product_price = null;
            $this->total_price = 0;
        }
    }

    public function updatedQuantity(): void
    {
        $this->calculateTotal();
    }

    public function calculateTotal(): void
    {
        if ($this->product_price !== null && $this->quantity > 0) {
            $this->total_price = $this->product_price * $this->quantity;
        } else {
            $this->total_price = 0;
        }
    }

    public function createOrder(): void
    {
        $this->validate();

        try {
            $orderDTO = new OrderDTO(
                $this->customer_name,
                $this->created_date,
                $this->total_price,
                $this->comment
            );

            $orderItemDTO = new OrderItemDTO(
                $this->product_id,
                $this->quantity,
                $this->product_price
            );

            $this->orderService->createOrder($orderDTO, $orderItemDTO);

            $this->reset(['customer_name', 'comment', 'product_id', 'quantity', 'product_price', 'total_price']);
            $this->created_date = Carbon::now()->format('Y-m-d');

            Flux::modal('create-order')->close();
            Flux::toast(variant: 'success', text: "Заказ успешно создан.");
            $this->dispatch('order-created');
        } catch (\Exception $e) {
            Flux::toast(variant: 'danger', text: "Ошибка при создании заказа: " . $e->getMessage());
        }
    }

    public function render(): View
    {
        return view('livewire.orders.order-create');
    }
}
