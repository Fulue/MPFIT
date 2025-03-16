<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <flux:heading size="xl">Заказы</flux:heading>
    <flux:card>
        <div class="flex justify-between mb-4">
            <flux:tabs variant="segmented">
                <flux:tab wire:click="filterByStatus(null)" icon="bars-3">Все</flux:tab>
                <flux:tab wire:click="filterByStatus('new')" icon="bell">Новые</flux:tab>
                <flux:tab wire:click="filterByStatus('completed')" icon="check-circle">Выполненные</flux:tab>
            </flux:tabs>
            <livewire:orders.order-create />
        </div>

        <flux:table :paginate="$this->orders">
            <flux:table.columns>
                <flux:table.column sortable :sorted="$sortBy === 'id'" :direction="$sortDirection" wire:click="sort('id')">
                    № заказа
                </flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'created_date'" :direction="$sortDirection" wire:click="sort('created_date')">
                    Дата создания
                </flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'customer_name'" :direction="$sortDirection" wire:click="sort('customer_name')">
                    ФИО покупателя
                </flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'status'" :direction="$sortDirection" wire:click="sort('status')">
                    Статус
                </flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'total_price'" :direction="$sortDirection" wire:click="sort('total_price')">
                    Итоговая сумма
                </flux:table.column>
                <flux:table.column>
                    Действия
                </flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($this->orders as $order)
                    <flux:table.row :key="$order->id">
                        <flux:table.cell>
                            {{ $order->id }}
                        </flux:table.cell>

                        <flux:table.cell>
                            {{ \Carbon\Carbon::parse($order->created_date)->format('d.m.Y') }}
                        </flux:table.cell>

                        <flux:table.cell>
                            {{ $order->customer_name }}
                        </flux:table.cell>

                        <flux:table.cell>
                            @if($order->status === 'new')
                                <flux:badge variant="warning">Новый</flux:badge>
                            @else
                                <flux:badge variant="success">Выполнен</flux:badge>
                            @endif
                        </flux:table.cell>

                        <flux:table.cell>
                            {{ number_format($order->total_price, 2, ',', ' ') }} ₽
                        </flux:table.cell>

                        <flux:table.cell>
                            <flux:dropdown position="bottom" align="end">
                                <flux:button icon="ellipsis-horizontal" />

                                <flux:menu>
                                    <flux:menu.item x-on:click="$flux.modal('view-order-{{ $order->id }}').show()" icon="eye">Просмотр</flux:menu.item>

                                    @if($order->status === 'new')
                                        <flux:menu.item wire:click="completeOrder({{ $order->id }})" icon="check-circle">Выполнить</flux:menu.item>
                                    @endif

                                    <flux:menu.item wire:click="deleteOrder({{ $order->id }})" icon="trash" variant="danger">Удалить</flux:menu.item>
                                </flux:menu>
                            </flux:dropdown>

                            <flux:modal name="view-order-{{ $order->id }}" class="md:w-96">
                                <livewire:orders.order-view :order="$order" :key="'view-'.$order->id" />
                            </flux:modal>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </flux:card>
</div>
