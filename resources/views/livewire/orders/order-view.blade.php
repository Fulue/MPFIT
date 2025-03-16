<div>
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">Заказ №{{ $order->id }}</flux:heading>
            <flux:subheading>Информация о заказе</flux:subheading>
        </div>

        <flux:card class="space-y-2">
            <div class="flex justify-between">
                <flux:subheading>Дата создания:</flux:subheading>
                <div class="font-medium">{{ \Carbon\Carbon::parse($order->created_date)->format('d.m.Y') }}</div>
            </div>

            <div class="flex justify-between">
                <flux:subheading>ФИО покупателя:</flux:subheading>
                <div class="font-medium">{{ $order->customer_name }}</div>
            </div>

            <div class="flex justify-between">
                <flux:subheading>Статус:</flux:subheading>
                <div>
                    @if($order->status === 'new')
                        <flux:badge size="sm" color="orange">Новый</flux:badge>
                    @else
                        <flux:badge size="sm" color="emerald">Выполнен</flux:badge>
                    @endif
                </div>
            </div>

            <div class="flex justify-between">
                <flux:subheading>Итоговая сумма:</flux:subheading>
                <div class="font-medium">{{ number_format($order->total_price, 2, ',', ' ') }} ₽</div>
            </div>
        </flux:card>

        <div>
            <div class="font-medium mb-2">Товары в заказе:</div>
            <flux:card class="space-y-2">
                @foreach($order->orderItems as $item)
                    <div class="border-b pb-2 last:border-b-0 last:pb-0 space-y-2">
                        <div class="flex justify-between">
                            <flux:subheading>{{ $item->product->name }}</flux:subheading>
                            <div>
                                <flux:badge size="sm">{{ $item->product->category->name }}</flux:badge>
                            </div>
                        </div>
                        <div class="flex justify-between text-sm mt-1">
                            <flux:subheading>
                                Цена: {{ number_format($item->price, 2, ',', ' ') }} ₽ × {{ $item->quantity }} шт.
                            </flux:subheading>
                            <div class="font-medium">
                                {{ number_format($item->price * $item->quantity, 2, ',', ' ') }} ₽
                            </div>
                        </div>
                    </div>
                @endforeach
            </flux:card>
        </div>

        @if($order->comment)
            <div>
                <div class="font-medium mb-2">Комментарий покупателя:</div>
                <flux:card>
                    {{ $order->comment }}
                </flux:card>
            </div>
        @endif

        <div class="flex justify-end space-x-3">
            @if($order->status === 'new')
                <flux:button wire:click="completeOrder" variant="primary" >
                    Выполнен
                </flux:button>
            @endif

            <flux:button
                type="button"
                variant="filled"
                x-on:click="$flux.modal('view-order-' + {{ $order->id }}).close()"
            >
                Закрыть
            </flux:button>
        </div>
    </div>
</div>
