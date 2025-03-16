@props([
    'direction' => null,
    'sortable' => false,
    'sorted' => false,
    'align' => 'start',
])

@php
$classes = Flux::classes()
    ->add('py-3 px-3 first:pl-0 last:pr-0')
    ->add('text-left text-sm font-medium text-zinc-800 dark:text-white')
    ->add(match($align) {
        'center' => 'group/center-align',
        'end' => 'group/right-align',
        // Right is @deprecated but needed for backwards compatibility...
        'right' => 'group/right-align',
        default => '',
    })
    // If the last column is sortable, remove the right negative margin that the sortable applies to itself, as the
    // negative margin caused the last column to overflow the table creating an unnecessary horizontal scrollbar...
    ->add('**:data-flux-table-sortable:last:mr-0')
    ;
@endphp

<th {{ $attributes->class($classes) }} data-flux-column>
    <?php if ($sortable): ?>
        <div class="flex in-[.group\/center-align]:justify-center in-[.group\/right-align]:justify-end">
            <flux:table.sortable :$sorted :direction="$direction">
                <div>{{ $slot }}</div>
            </flux:table.sortable>
        </div>
    <?php else: ?>
        <div class="flex in-[.group\/center-align]:justify-center in-[.group\/right-align]:justify-end">{{ $slot }}</div>
    <?php endif; ?>
</th>
