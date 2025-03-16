<div>
    <flux:modal.trigger name="create-order">
        <flux:button icon="plus" variant="filled">
            Создать заказ
        </flux:button>
    </flux:modal.trigger>

    <flux:modal name="create-order" class="md:w-96">
        <form wire:submit="createOrder">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Создание заказа</flux:heading>
                    <flux:subheading>Заполните данные для создания заказа.</flux:subheading>
                </div>

                <div>
                    <flux:input
                        label="ФИО покупателя"
                        placeholder="Введите ФИО покупателя"
                        wire:model="customer_name"
                        :invalid="$errors->first('customer_name')"
                        required
                    />
                </div>

                <div>
                    <flux:date-picker
                        label="Дата создания"
                        wire:model="created_date"
                        :invalid="$errors->first('created_date')"
                        required
                    />
                </div>

                <div>
                    <flux:select
                        variant="listbox"
                        label="Товар"
                        placeholder="Выберите товар"
                        wire:model="product_id"
                        :invalid="$errors->first('product_id')"
                        required
                        searchable
                    >
                        <x-slot name="search">
                            <flux:select.search class="px-4" placeholder="Поиск товара..." />
                        </x-slot>
                        @foreach ($this->products as $product)
                            <flux:select.option class="break-words truncate" value="{{ $product['value'] }}">
                                {{ $product['label'] }}
                            </flux:select.option>
                        @endforeach
                    </flux:select>
                </div>

                <div>
                    <flux:input
                        type="number"
                        label="Количество"
                        placeholder="Укажите количество"
                        wire:model="quantity"
                        :invalid="$errors->first('quantity')"
                        min="1"
                        required
                    />
                </div>

                @if($total_price > 0)
                    <div class="bg-gray-100 p-3 rounded-md">
                        <div class="text-sm text-gray-500">Итоговая сумма:</div>
                        <div class="font-medium text-lg">{{ number_format($total_price, 2, ',', ' ') }} ₽</div>
                    </div>
                @endif

                <div>
                    <flux:textarea
                        label="Комментарий"
                        placeholder="Введите комментарий к заказу (необязательно)"
                        wire:model="comment"
                        :invalid="$errors->first('comment')"
                    />
                </div>

                <div class="flex justify-end space-x-3">
                    <flux:button
                        type="button"
                        variant="filled"
                        x-on:click="$flux.modal('create-order').close()"
                    >
                        Отмена
                    </flux:button>
                    <flux:button type="submit" variant="primary">
                        Создать заказ
                    </flux:button>
                </div>
            </div>
        </form>
    </flux:modal>
</div>
