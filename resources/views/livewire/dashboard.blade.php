<x-ui-page>
    <x-slot name="navbar">
        <x-ui-page-navbar title="Dashboard" icon="heroicon-o-home" />
    </x-slot>

    <x-ui-page-container>
        <div class="space-y-6">
            {{-- Welcome Section --}}
            <x-ui-panel title="Willkommen im Location Management" subtitle="Verwalte deine Sites und Locations">
                <div class="p-6 text-center">
                    <div class="mb-4">
                        @svg('heroicon-o-map-pin', 'w-16 h-16 text-[var(--ui-primary)] mx-auto')
                    </div>
                    <h2 class="text-xl font-semibold text-[var(--ui-secondary)] mb-2">
                        Location Management
                    </h2>
                    <p class="text-[var(--ui-muted)]">
                        Hier kannst du in Zukunft deine Sites und Locations verwalten.
                    </p>
                </div>
            </x-ui-panel>

            {{-- Placeholder Stats --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <x-ui-dashboard-tile
                    title="Sites"
                    :count="0"
                    subtitle="Gesamt"
                    icon="globe-alt"
                    variant="secondary"
                    size="lg"
                />
                <x-ui-dashboard-tile
                    title="Aktive Sites"
                    :count="0"
                    subtitle="Aktiv"
                    icon="check-circle"
                    variant="secondary"
                    size="lg"
                />
                <x-ui-dashboard-tile
                    title="Locations"
                    :count="0"
                    subtitle="Gesamt"
                    icon="map-pin"
                    variant="secondary"
                    size="lg"
                />
                <x-ui-dashboard-tile
                    title="International"
                    :count="0"
                    subtitle="Locations"
                    icon="globe-alt"
                    variant="secondary"
                    size="lg"
                />
            </div>
        </div>
    </x-ui-page-container>

    <x-slot name="sidebar">
        <x-ui-page-sidebar title="Schnellzugriff" width="w-80" :defaultOpen="true">
            <div class="p-6 space-y-6">
                {{-- Quick Actions --}}
                <div>
                    <h3 class="text-sm font-bold text-[var(--ui-secondary)] uppercase tracking-wider mb-3">Aktionen</h3>
                    <div class="space-y-2">
                        <x-ui-button variant="success" size="sm" x-data @click="$dispatch('open-modal-create-site')" class="w-full">
                            <span class="flex items-center gap-2">
                                @svg('heroicon-o-plus', 'w-4 h-4')
                                Neue Site
                            </span>
                        </x-ui-button>
                        <x-ui-button variant="success" size="sm" x-data @click="$dispatch('open-modal-create-location')" class="w-full">
                            <span class="flex items-center gap-2">
                                @svg('heroicon-o-plus', 'w-4 h-4')
                                Neue Location
                            </span>
                        </x-ui-button>
                        <x-ui-button variant="secondary-outline" size="sm" :href="route('location.sites.index')" wire:navigate class="w-full">
                            <span class="flex items-center gap-2">
                                @svg('heroicon-o-globe-alt', 'w-4 h-4')
                                Sites
                            </span>
                        </x-ui-button>
                        <x-ui-button variant="secondary-outline" size="sm" :href="route('location.locations.index')" wire:navigate class="w-full">
                            <span class="flex items-center gap-2">
                                @svg('heroicon-o-map-pin', 'w-4 h-4')
                                Locations
                            </span>
                        </x-ui-button>
                    </div>
                </div>

                {{-- Quick Stats --}}
                <div>
                    <h3 class="text-sm font-bold text-[var(--ui-secondary)] uppercase tracking-wider mb-3">Schnellstatistiken</h3>
                    <div class="space-y-3">
                        <div class="p-3 bg-[var(--ui-muted-5)] rounded-lg border border-[var(--ui-border)]/40">
                            <div class="text-xs text-[var(--ui-muted)]">Sites</div>
                            <div class="text-lg font-bold text-[var(--ui-secondary)]">0</div>
                        </div>
                        <div class="p-3 bg-[var(--ui-muted-5)] rounded-lg border border-[var(--ui-border)]/40">
                            <div class="text-xs text-[var(--ui-muted)]">Locations</div>
                            <div class="text-lg font-bold text-[var(--ui-secondary)]">0</div>
                        </div>
                    </div>
                </div>

                {{-- Recent Activity --}}
                <div>
                    <h3 class="text-sm font-bold text-[var(--ui-secondary)] uppercase tracking-wider mb-3">Letzte Aktivitäten</h3>
                    <div class="space-y-2 text-sm">
                        <div class="p-2 rounded border border-[var(--ui-border)]/60 bg-[var(--ui-muted-5)]">
                            <div class="font-medium text-[var(--ui-secondary)] truncate">Dashboard geladen</div>
                            <div class="text-[var(--ui-muted)] text-xs">vor 1 Minute</div>
                        </div>
                    </div>
                </div>
            </div>
        </x-ui-page-sidebar>
    </x-slot>

    <x-slot name="activity">
        <x-ui-page-sidebar title="Aktivitäten" width="w-80" :defaultOpen="false" storeKey="activityOpen" side="right">
            <div class="p-4 space-y-4">
                <div class="text-sm text-[var(--ui-muted)]">Letzte Aktivitäten</div>
                <div class="space-y-3 text-sm">
                    <div class="p-2 rounded border border-[var(--ui-border)]/60 bg-[var(--ui-muted-5)]">
                        <div class="font-medium text-[var(--ui-secondary)] truncate">Dashboard geladen</div>
                        <div class="text-[var(--ui-muted)]">vor 1 Minute</div>
                    </div>
                </div>
            </div>
        </x-ui-page-sidebar>
    </x-slot>

    {{-- Modals --}}
    <livewire:location.create-location-modal />
    <livewire:location.create-site-modal />
</x-ui-page>
