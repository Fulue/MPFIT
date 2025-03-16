<?php

namespace App\Contracts\Services;

use App\DTO\ProductDTO;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductServiceInterface
{
    /**
     * Получить список товаров с пагинацией и сортировкой.
     *
     * @param string $sortBy
     * @param string $sortDirection
     * @return LengthAwarePaginator
     */
    public function getProducts(string $sortBy, string $sortDirection): LengthAwarePaginator;

    /**
     * Создать новый товар.
     *
     * @param ProductDTO $productDTO
     * @return ProductDTO
     */
    public function createProduct(ProductDTO $productDTO): ProductDTO;

    /**
     * Обновить существующий товар.
     *
     * @param int $productId
     * @param ProductDTO $productDTO
     * @return bool
     */
    public function updateProduct(int $productId, ProductDTO $productDTO): bool;

    /**
     * Удалить товар.
     *
     * @param int $productId
     * @return bool
     */
    public function deleteProduct(int $productId): bool;

    /**
     * Получить категории для выпадающего списка.
     *
     * @return array
     */
    public function getCategoriesForSelect(): array;
}
