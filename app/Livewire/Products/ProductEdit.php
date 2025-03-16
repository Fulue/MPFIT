<?php

namespace App\Livewire\Products;

use App\Contracts\Services\ProductServiceInterface;
use App\DTO\ProductDTO;
use App\Models\Product;
use Flux\Flux;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ProductEdit extends Component
{
    private ProductServiceInterface $productService;

    public Product $product;

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

    public function mount(Product $product): void
    {
        $this->product = $product;
        $this->name = $product->name;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->category_id = $product->category_id;
    }

    #[Computed]
    public function categories(): array
    {
        return $this->productService->getCategoriesForSelect();
    }

    public function updateProduct(): void
    {
        $validatedData = $this->validate();

        try {
            $productDTO = ProductDTO::fromArray($validatedData);
            $result = $this->productService->updateProduct($this->product->id, $productDTO);

            if ($result) {
                Flux::modal('edit-product-' . $this->product->id)->close();
                Flux::toast(variant: 'success', text: "Товар успешно обновлен.");
                $this->dispatch('product-updated');
            } else {
                Flux::toast(variant: 'danger', text: "Не удалось обновить товар.");
            }
        } catch (\Exception $e) {
            Flux::toast(variant: 'danger', text: "Ошибка при обновлении товара: " . $e->getMessage());
        }
    }

    public function render(): View
    {
        return view('livewire.products.product-edit');
    }
}
