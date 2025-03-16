<?php

namespace App\Livewire\Products;

use App\Contracts\Services\ProductServiceInterface;
use App\DTO\ProductDTO;
use Flux\Flux;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ProductCreate extends Component
{
    private ProductServiceInterface $productService;

    #[Validate('required', message: 'Название товара обязательно.')]
    #[Validate('min:3', message: 'Название товара должно содержать не менее 3 символов.')]
    #[Validate('max:255', message: 'Название товара не должно превышать 255 символов.')]
    public string $name = '';

    #[Validate('nullable')]
    #[Validate('string', message: 'Описание должно быть текстом.')]
    public ?string $description = '';

    #[Validate('required', message: 'Цена товара обязательна.')]
    #[Validate('numeric', message: 'Цена должна быть числом.')]
    #[Validate('min:0.01', message: 'Цена должна быть больше нуля.')]
    public float $price = 0.00;

    #[Validate('required', message: 'Категория товара обязательна.')]
    #[Validate('exists:categories,id', message: 'Выбранная категория не существует.')]
    public ?int $category_id = null;

    public function boot(ProductServiceInterface $productService): void
    {
        $this->productService = $productService;
    }

    #[Computed]
    public function categories(): array
    {
        return $this->productService->getCategoriesForSelect();
    }

    public function createProduct(): void
    {
        $validatedData = $this->validate();

        try {
            $productDTO = ProductDTO::fromArray($validatedData);
            $this->productService->createProduct($productDTO);

            $this->reset(['name', 'description', 'price', 'category_id']);

            Flux::modal('create-product')->close();
            Flux::toast(variant: 'success', text: "Товар успешно создан.");
            $this->dispatch('product-created');
        } catch (\Exception $e) {
            Flux::toast(variant: 'danger', text: "Ошибка при создании товара: " . $e->getMessage());
        }
    }

    public function render(): View
    {
        return view('livewire.products.product-create');
    }
}
