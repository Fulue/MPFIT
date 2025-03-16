<?php

namespace App\DTO;

readonly class OrderItemDTO
{
    /**
     * @param int $product_id ID товара
     * @param int $quantity Количество товара
     * @param float $price Цена за единицу товара
     * @param int|null $order_id ID заказа (опционально)
     * @param int|null $id ID элемента заказа (опционально)
     */
    public function __construct(
        public int   $product_id,
        public int   $quantity,
        public float $price,
        public ?int  $order_id = null,
        public ?int  $id = null
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
            (int) $data['product_id'],
            (int) $data['quantity'],
            (float) $data['price'],
            isset($data['order_id']) ? (int) $data['order_id'] : null,
            isset($data['id']) ? (int) $data['id'] : null
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
            'product_id' => $this->product_id,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'order_id' => $this->order_id,
            'id' => $this->id,
        ];
    }

    /**
     * Получить общую стоимость позиции заказа.
     *
     * @return float
     */
    public function getTotalPrice(): float
    {
        return $this->price * $this->quantity;
    }
}
