<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <flux:heading size="xl">Товары</flux:heading>
    <flux:card>
        <div class="flex justify-between mb-4">
            <livewire:products.product-create />
        </div>

        <flux:table :paginate="$this->products">
            <flux:table.columns>
                <flux:table.column sortable :sorted="$sortBy === 'name'" :direction="$sortDirection" wire:click="sort('name')">
                    Название
                </flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'created_at'" :direction="$sortDirection" wire:click="sort('created_at')">
                    Дата создания
                </flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'category_id'" :direction="$sortDirection" wire:click="sort('category_id')">
                    Категория
                </flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'price'" :direction="$sortDirection" wire:click="sort('price')">
                    Цена
                </flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($this->products as $product)
                    <flux:table.row :key="$product->id">
                        <flux:table.cell>
                            {{ $product->name }}
                        </flux:table.cell>

                        <flux:table.cell>
                            {{ $product->created_at->format('d.m.Y H:i') }}
                        </flux:table.cell>

                        <flux:table.cell>
                            <flux:badge>
                                {{ $product->category->name }}
                            </flux:badge>
                        </flux:table.cell>

                        <flux:table.cell>
                            {{ number_format($product->price, 2, ',', ' ') }} ₽
                        </flux:table.cell>

                        <flux:table.cell>
                            <flux:dropdown position="bottom" align="end">
                                <flux:button icon="ellipsis-horizontal" />

                                <flux:menu>
                                    <flux:menu.item x-on:click="$flux.modal('edit-product-{{ $product->id }}').show()" icon="pencil">Редактировать</flux:menu.item>
                                    <flux:menu.item wire:click="deleteProduct({{ $product->id }})" icon="trash" variant="danger">Удалить</flux:menu.item>
                                </flux:menu>
                            </flux:dropdown>

                            <flux:modal name="edit-product-{{ $product->id }}" class="md:w-96">
                                <livewire:products.product-edit :product="$product" :key="'edit-'.$product->id" />
                            </flux:modal>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </flux:card>

</div>
