<div>
    <form wire:submit="updateProduct">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Редактирование товара</flux:heading>
                <flux:subheading>Измените необходимые поля.</flux:subheading>
            </div>

            <div>
                <flux:input
                    label="Название"
                    placeholder="Введите название товара"
                    wire:model="name"
                    :invalid="$errors->first('name')"
                    required
                />
            </div>

            <div>
                <flux:select
                    variant="listbox"
                    label="Категория"
                    placeholder="Выберите категорию"
                    wire:model="category_id"
                    :invalid="$errors->first('category_id')"
                >
                    @foreach ($this->categories as $categorie)
                        <flux:select.option value="{{ $categorie['value'] }}">
                            {{ $categorie['label'] }}
                        </flux:select.option>
                    @endforeach
                </flux:select>
            </div>

            <div>
                <flux:textarea
                    label="Описание"
                    placeholder="Введите описание товара"
                    wire:model="description"
                    :invalid="$errors->first('description')"
                />
            </div>

            <div>
                <flux:input
                    label="Цена"
                    placeholder="Введите цену товара"
                    wire:model="price"
                    :invalid="$errors->first('price')"
                    type="number"
                    step="0.01"
                    min="0"
                    required
                />
            </div>

            <div class="flex justify-end space-x-3">
                <flux:button
                    type="button"
                    variant="filled"
                    x-on:click="$flux.modal('edit-product-' + {{ $product->id }}).close()"
                >
                    Отмена
                </flux:button>
                <flux:button type="submit" variant="primary">
                    Сохранить изменения
                </flux:button>
            </div>
        </div>
    </form>
</div>
