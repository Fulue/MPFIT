<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Список названий продуктов для различных категорий.
     *
     * @var array<string, array<string>>
     */
    protected $productNames = [
        'легкий' => [
            'Ноутбук Acer Swift',
            'Планшет Samsung Galaxy Tab',
            'Смартфон iPhone',
            'Смарт-часы Apple Watch',
            'Беспроводные наушники Sony',
            'Электронная книга Kindle',
            'Портативная колонка JBL',
            'Фитнес-браслет Xiaomi',
            'Внешний аккумулятор Anker',
            'Карта памяти SanDisk'
        ],
        'хрупкий' => [
            'Хрустальная ваза',
            'Стеклянный сервиз',
            'Керамическая статуэтка',
            'Фарфоровый чайный набор',
            'Настенное зеркало',
            'Оптический микроскоп',
            'Коллекционная фигурка',
            'Модель корабля из стекла',
            'Набор винтажных бокалов',
            'Декоративная лампа'
        ],
        'тяжелый' => [
            'Холодильник LG',
            'Стиральная машина Bosch',
            'Электрическая плита Gorenje',
            'Телевизор Samsung QLED',
            'Беговая дорожка Torneo',
            'Диван-кровать Milano',
            'Шкаф-купе Командор',
            'Кухонный гарнитур Икеа',
            'Велотренажер Kettler',
            'Чугунная ванна Roca'
        ]
    ];

    /**
     * Заготовки для описания продуктов.
     *
     * @var array<string, array<string>>
     */
    protected $descriptionParts = [
        'intro' => [
            'Этот высококачественный продукт',
            'Данное изделие премиум-класса',
            'Современный и функциональный товар',
            'Стильный и практичный предмет',
            'Надежный и долговечный продукт',
            'Эргономичное и удобное изделие',
        ],
        'features' => [
            'обладает превосходными характеристиками',
            'имеет стильный и современный дизайн',
            'отличается высоким качеством изготовления',
            'сочетает в себе практичность и эстетику',
            'создан с использованием инновационных технологий',
            'выполнен из высококачественных материалов',
        ],
        'benefits' => [
            'обеспечивает максимальный комфорт при использовании',
            'станет прекрасным дополнением вашего интерьера',
            'существенно упростит выполнение повседневных задач',
            'прослужит вам долгие годы без потери качества',
            'поможет сэкономить время и усилия',
            'подчеркнет ваш безупречный вкус',
        ],
        'conclusion' => [
            'Идеальный выбор для тех, кто ценит качество и надежность.',
            'Рекомендуем для тех, кто предпочитает лучшее.',
            'Обязательно оценят все члены вашей семьи.',
            'Не упустите возможность сделать вашу жизнь комфортнее.',
            'Отличное решение для дома и офиса.',
            'Будем рады помочь с выбором аксессуаров к данному товару.',
        ]
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Получаем случайную категорию
        $category = Category::inRandomOrder()->first();
        $categoryName = $category->name;

        // Выбираем случайное название товара из соответствующей категории
        $name = $this->faker->randomElement($this->productNames[$categoryName] ??
            array_merge(...array_values($this->productNames)));

        // Генерируем уникальное описание из заготовленных фраз
        $description = $this->generateDescription();

        return [
            'name' => $name,
            'category_id' => $category->id,
            'description' => $description,
            'price' => $this->faker->randomFloat(2, 100, 10000),
        ];
    }

    /**
     * Генерирует описание продукта из заготовленных фраз.
     *
     * @return string
     */
    protected function generateDescription(): string
    {
        $intro = $this->faker->randomElement($this->descriptionParts['intro']);
        $features = $this->faker->randomElement($this->descriptionParts['features']);
        $benefits = $this->faker->randomElement($this->descriptionParts['benefits']);
        $conclusion = $this->faker->randomElement($this->descriptionParts['conclusion']);

        return "{$intro} {$features}. {$benefits}. {$conclusion}";
    }

}
