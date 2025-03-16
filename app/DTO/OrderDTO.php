<?php

namespace App\DTO;

readonly class OrderDTO
{
    /**
     * @param string $customer_name ФИО покупателя
     * @param string $created_date Дата создания заказа
     * @param float $total_price Итоговая стоимость заказа
     * @param string|null $comment Комментарий покупателя
     * @param string|null $status Статус заказа
     * @param int|null $id ID заказа (для существующих заказов)
     */
    public function __construct(
        public string  $customer_name,
        public string  $created_date,
        public float   $total_price,
        public ?string $comment = null,
        public ?string $status = null,
        public ?int    $id = null
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
            $data['customer_name'],
            $data['created_date'],
            (float) $data['total_price'],
            $data['comment'] ?? null,
            $data['status'] ?? null,
            $data['id'] ?? null
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
            'customer_name' => $this->customer_name,
            'created_date' => $this->created_date,
            'total_price' => $this->total_price,
            'comment' => $this->comment,
            'status' => $this->status,
            'id' => $this->id,
        ];
    }
}
