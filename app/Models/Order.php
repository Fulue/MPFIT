<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    /**
     * Статусы заказа.
     */
    const STATUS_NEW = 'new';
    const STATUS_COMPLETED = 'completed';

    /**
     * Атрибуты, которые можно массово назначать.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_name',
        'created_date',
        'status',
        'comment',
        'total_price',
    ];

    /**
     * Атрибуты, которые должны быть приведены к нативным типам.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_date' => 'date',
        'total_price' => 'decimal:2',
    ];

    /**
     * Получить элементы данного заказа.
     *
     * @return HasMany
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Проверить, является ли заказ новым.
     *
     * @return bool
     */
    public function isNew(): bool
    {
        return $this->status === self::STATUS_NEW;
    }

    /**
     * Проверить, является ли заказ выполненным.
     *
     * @return bool
     */
    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    /**
     * Отметить заказ как выполненный.
     *
     * @return bool
     */
    public function markAsCompleted(): bool
    {
        $this->status = self::STATUS_COMPLETED;
        return $this->save();
    }
}
