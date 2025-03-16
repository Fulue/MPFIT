<x-layouts.app.sidebar :title="$title ?? null">
    <flux:main class="xl:w-7xl xl:mx-auto">
        {{ $slot }}
    </flux:main>
    @persist('toast')
        <flux:toast />
    @endpersist
</x-layouts.app.sidebar>
