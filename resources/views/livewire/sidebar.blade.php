{{-- resources/views/vendor/location/livewire/sidebar-content.blade.php --}}
<div>
    {{-- Modul Header --}}
    <div x-show="!collapsed" class="p-3 text-sm italic text-[var(--ui-secondary)] uppercase border-b border-[var(--ui-border)] mb-2">
        Location
    </div>

    {{-- Abschnitt: Allgemein (über UI-Komponenten) --}}
    <x-ui-sidebar-list label="Allgemein">
        <x-ui-sidebar-item :href="route('location.dashboard')">
            @svg('heroicon-o-home', 'w-4 h-4 text-[var(--ui-secondary)]')
            <span class="ml-2 text-sm">Dashboard</span>
        </x-ui-sidebar-item>
    </x-ui-sidebar-list>

    {{-- Abschnitt: Verwaltung --}}
    <x-ui-sidebar-list label="Verwaltung">
        <x-ui-sidebar-item :href="route('location.sites.index')">
            @svg('heroicon-o-globe-alt', 'w-4 h-4 text-[var(--ui-secondary)]')
            <span class="ml-2 text-sm">Sites</span>
        </x-ui-sidebar-item>
    </x-ui-sidebar-list>

    {{-- Collapsed: Icons-only für Allgemein --}}
    <div x-show="collapsed" class="px-2 py-2 border-b border-[var(--ui-border)]">
        <div class="flex flex-col gap-2">
            <a href="{{ route('location.dashboard') }}" wire:navigate class="flex items-center justify-center p-2 rounded-md text-[var(--ui-secondary)] hover:bg-[var(--ui-muted-5)]">
                @svg('heroicon-o-home', 'w-5 h-5')
            </a>
        </div>
    </div>

    {{-- Collapsed: Icons-only für Verwaltung --}}
    <div x-show="collapsed" class="px-2 py-2 border-b border-[var(--ui-border)]">
        <div class="flex flex-col gap-2">
            <a href="{{ route('location.sites.index') }}" wire:navigate class="flex items-center justify-center p-2 rounded-md text-[var(--ui-secondary)] hover:bg-[var(--ui-muted-5)]">
                @svg('heroicon-o-globe-alt', 'w-5 h-5')
            </a>
        </div>
    </div>

    {{-- Abschnitt: Settings --}}
    <x-ui-sidebar-list label="Settings">
        <x-ui-sidebar-item :href="route('location.settings.occasions.index')">
            @svg('heroicon-o-calendar-days', 'w-4 h-4 text-[var(--ui-secondary)]')
            <span class="ml-2 text-sm">Anlässe</span>
        </x-ui-sidebar-item>
        <x-ui-sidebar-item :href="route('location.settings.seatings.index')">
            @svg('heroicon-o-square-3-stack-3d', 'w-4 h-4 text-[var(--ui-secondary)]')
            <span class="ml-2 text-sm">Bestuhlungen</span>
        </x-ui-sidebar-item>
    </x-ui-sidebar-list>

    {{-- Collapsed: Icons-only für Settings --}}
    <div x-show="collapsed" class="px-2 py-2 border-b border-[var(--ui-border)]">
        <div class="flex flex-col gap-2">
            <a href="{{ route('location.settings.occasions.index') }}" wire:navigate class="flex items-center justify-center p-2 rounded-md text-[var(--ui-secondary)] hover:bg-[var(--ui-muted-5)]">
                @svg('heroicon-o-calendar-days', 'w-5 h-5')
            </a>
            <a href="{{ route('location.settings.seatings.index') }}" wire:navigate class="flex items-center justify-center p-2 rounded-md text-[var(--ui-secondary)] hover:bg-[var(--ui-muted-5)]">
                @svg('heroicon-o-square-3-stack-3d', 'w-5 h-5')
            </a>
        </div>
    </div>
</div>
