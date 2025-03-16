<?php

namespace App\Services;

use App\Contracts\Repositories\ProductRepositoryInterface;
use App\Contracts\Services\ProductServiceInterface;
use App\DTO\ProductDTO;
use App\Models\Product;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class ProductService implements ProductServiceInterface
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getProducts(string $sortBy, string $sortDirection): LengthAwarePaginator
    {
        return $this->productRepository->getPaginatedProducts($sortBy, $sortDirection);
    }

    /**
     * @throws Exception
     */
    public function createProduct(ProductDTO $productDTO): ProductDTO
    {
        try {
            $product = $this->productRepository->createProduct($productDTO->toArray());

            return new ProductDTO(
                $product->name,
                $product->description,
                $product->price,
                $product->category_id,
                $product->id
            );
        } catch (Exception $e) {
            Log::error('Ошибка при создании товара: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * @throws Exception
     */
    public function updateProduct(int $productId, ProductDTO $productDTO): bool
    {
        try {
            $product = $this->productRepository->findById($productId);
            $result = $this->productRepository->updateProduct($product, $productDTO->toArray());

            return $result;
        } catch (Exception $e) {
            Log::error('Ошибка при обновлении товара: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * @throws Exception
     */
    public function deleteProduct(int $productId): bool
    {
        try {
            $result = $this->productRepository->deleteProduct($productId);

            return $result !== null;
        } catch (Exception $e) {
            Log::error('Ошибка при удалении товара: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getCategoriesForSelect(): array
    {
        return $this->productRepository->getCategoriesForSelect();
    }
}
