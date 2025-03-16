<x-layouts.app :title="__('Заказы')" xmlns:flux="http://www.w3.org/1999/xlink">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <flux:heading size="xl">Заказы</flux:heading>
        <flux:card>
            <flux:table class="w-full">
                <flux:table.columns>
                    <flux:table.column>Customer</flux:table.column>
                    <flux:table.column>Date</flux:table.column>
                    <flux:table.column>Status</flux:table.column>
                    <flux:table.column>Amount</flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    <flux:table.row>
                        <flux:table.cell>Lindsey Aminoff</flux:table.cell>
                        <flux:table.cell>Jul 29, 10:45 AM</flux:table.cell>
                        <flux:table.cell><flux:badge color="green" size="sm" inset="top bottom">Paid</flux:badge></flux:table.cell>
                        <flux:table.cell variant="strong">$49.00</flux:table.cell>
                    </flux:table.row>

                    <flux:table.row>
                        <flux:table.cell>Hanna Lubin</flux:table.cell>
                        <flux:table.cell>Jul 28, 2:15 PM</flux:table.cell>
                        <flux:table.cell><flux:badge color="green" size="sm" inset="top bottom">Paid</flux:badge></flux:table.cell>
                        <flux:table.cell variant="strong">$312.00</flux:table.cell>
                    </flux:table.row>

                    <flux:table.row>
                        <flux:table.cell>Kianna Bushevi</flux:table.cell>
                        <flux:table.cell>Jul 30, 4:05 PM</flux:table.cell>
                        <flux:table.cell><flux:badge color="zinc" size="sm" inset="top bottom">Refunded</flux:badge></flux:table.cell>
                        <flux:table.cell variant="strong">$132.00</flux:table.cell>
                    </flux:table.row>

                    <flux:table.row>
                        <flux:table.cell>Gustavo Geidt</flux:table.cell>
                        <flux:table.cell>Jul 27, 9:30 AM</flux:table.cell>
                        <flux:table.cell><flux:badge color="green" size="sm" inset="top bottom">Paid</flux:badge></flux:table.cell>
                        <flux:table.cell variant="strong">$31.00</flux:table.cell>
                    </flux:table.row>
                </flux:table.rows>
            </flux:table>
        </flux:card>
    </div>
</x-layouts.app>
