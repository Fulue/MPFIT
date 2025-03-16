<div class="flex flex-col items-start">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Внешний вид')" :subheading=" __('Обновите внешний вид вашего аккаунта')">
        <flux:radio.group x-data variant="segmented" x-model="$flux.appearance">
            <flux:radio value="light" icon="sun">{{ __('Светлая') }}</flux:radio>
            <flux:radio value="dark" icon="moon">{{ __('Тёмная') }}</flux:radio>
            <flux:radio value="system" icon="computer-desktop">{{ __('Системная') }}</flux:radio>
        </flux:radio.group>
    </x-settings.layout>
</div>
