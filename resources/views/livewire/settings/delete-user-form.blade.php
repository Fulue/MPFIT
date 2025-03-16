<section class="mt-10 space-y-6">
    <div class="relative mb-5">
        <flux:heading>{{ __('Удаление аккаунта') }}</flux:heading>
        <flux:subheading>{{ __('Удалите свою учетную запись и все ее ресурсы') }}</flux:subheading>
    </div>

    <flux:modal.trigger name="confirm-user-deletion">
        <flux:button variant="danger" x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
            {{ __('Удалить аккаунт') }}
        </flux:button>
    </flux:modal.trigger>

    <flux:modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable class="max-w-lg">
        <form wire:submit="deleteUser" class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Вы уверены, что хотите удалить свою учетную запись?') }}</flux:heading>

                <flux:subheading>
                    {{ __('Как только ваша учетная запись будет удалена, все ее ресурсы и данные будут удалены безвозвратно. Пожалуйста, введите свой пароль, чтобы подтвердить, что вы хотите удалить свою учетную запись безвозвратно.') }}
                </flux:subheading>
            </div>

            <flux:input wire:model="password" :label="__('Пароль')" type="password" />

            <div class="flex justify-end space-x-2">
                <flux:modal.close>
                    <flux:button variant="filled">{{ __('Отменить') }}</flux:button>
                </flux:modal.close>

                <flux:button variant="danger" type="submit">{{ __('Удалить') }}</flux:button>
            </div>
        </form>
    </flux:modal>
</section>
