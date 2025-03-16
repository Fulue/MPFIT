<?php

namespace App\DTO;

readonly class ProductDTO
{
    public function __construct(
        public readonly string $name,
        public readonly ?string $description,
        public readonly float $price,
        public readonly int $category_id,
        public readonly ?int $id = null
    ) {
    }

    /**
     * Создать DTO из массива данных.
     *
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['name'],
            $data['description'] ?? null,
            (float) $data['price'],
            (int) $data['category_id']
        );
    }

    /**
     * Преобразовать DTO в массив.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'category_id' => $this->category_id,
        ];
    }
}
