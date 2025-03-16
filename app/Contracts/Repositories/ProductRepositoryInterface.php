<?php

namespace App\Contracts\Repositories;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface
{
    /**
     * Получить продукт по идентификатору.
     *
     * @param int $id
     * @return ?Product
     */
    public function findById(int $id): ?Product;

    /**
     * Получить список продуктов с пагинацией и сортировкой.
     *
     * @param string $sortBy
     * @param string $sortDirection
     * @return LengthAwarePaginator
     */
    public function getPaginatedProducts(string $sortBy, string $sortDirection): LengthAwarePaginator;

    /**
     * Создать новый продукт.
     *
     * @param array $data
     * @return Product
     */
    public function createProduct(array $data): Product;

    /**
     * Обновить существующий продукт.
     *
     * @param Product $product
     * @param array $data
     * @return bool
     */
    public function updateProduct(Product $product, array $data): bool;

    /**
     * Удалить продукт.
     *
     * @param int $productId
     * @return ?string Имя удаленного продукта или null, если продукт не найден
     */
    public function deleteProduct(int $productId): ?string;

    /**
     * Получить форматированный список категорий для выпадающего списка.
     *
     * @return array
     */
    public function getCategoriesForSelect(): array;
}
