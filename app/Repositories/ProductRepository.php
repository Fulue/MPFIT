<?php

namespace App\Repositories;

use App\Contracts\Repositories\ProductRepositoryInterface;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductRepository implements ProductRepositoryInterface
{
    public function findById(int $id): ?Product
    {
        return Product::query()->find($id);
    }
    public function getPaginatedProducts(string $sortBy, string $sortDirection): LengthAwarePaginator
    {
        return Product::query()
            ->with('category')
            ->when($sortBy === 'category_id', function ($query) use ($sortDirection) {
                return $query->join('categories', 'products.category_id', '=', 'categories.id')
                    ->orderBy('categories.name', $sortDirection)
                    ->select('products.*');
            }, function ($query) use ($sortBy, $sortDirection) {
                return $query->orderBy($sortBy, $sortDirection);
            })
            ->paginate(10);
    }

    public function createProduct(array $data): Product
    {
        return Product::query()->create([
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'category_id' => $data['category_id'],
        ]);
    }

    public function updateProduct(Product $product, array $data): bool
    {
        return $product->update([
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'category_id' => $data['category_id'],
        ]);
    }

    public function deleteProduct(int $productId): ?string
    {
        $product = Product::query()->find($productId);

        if ($product) {
            $productName = $product->name;
            $product->delete();
            return $productName;
        }

        return null;
    }

    public function getCategoriesForSelect(): array
    {
        return Category::query()
            ->orderBy('name')
            ->get()
            ->map(function ($category) {
                return [
                    'value' => $category->id,
                    'label' => $category->name,
                ];
            })
            ->toArray();
    }
}
