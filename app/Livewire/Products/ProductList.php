<?php

namespace App\Livewire\Products;

use App\Contracts\Services\ProductServiceInterface;
use Flux\Flux;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ProductList extends Component
{
    use WithPagination;

    private ProductServiceInterface $productService;

    public string $sortBy = 'created_at';
    public string $sortDirection = 'desc';

    public function boot(ProductServiceInterface $productService): void
    {
        $this->productService = $productService;
    }

    #[On('product-created')]
    #[On('product-updated')]
    #[On('product-deleted')]
    public function refreshProducts(): void
    {
        $this->reset(['sortBy', 'sortDirection']);
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

    #[Computed]
    public function products(): LengthAwarePaginator
    {
        return $this->productService->getProducts($this->sortBy, $this->sortDirection);
    }

    public function deleteProduct(int $productId): void
    {
        try {
            $result = $this->productService->deleteProduct($productId);

            if ($result) {
                Flux::toast(variant: 'success', text: "Товар успешно удален.");
                $this->dispatch('product-deleted');
            } else {
                Flux::toast(variant: 'danger', text: "Товар не найден.");
            }
        } catch (\Exception $e) {
            Flux::toast(variant: 'danger', text: "Ошибка при удалении товара: " . $e->getMessage());
        }
    }

    public function render(): View
    {
        return view('livewire.products.product-list');
    }
}
