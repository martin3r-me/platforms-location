<x-ui-page>
    <x-slot name="navbar">
        <x-ui-page-navbar title="Dashboard" icon="heroicon-o-home" />
    </x-slot>

    <x-ui-page-container>
        <div class="space-y-6">
            {{-- Welcome Section --}}
            <x-ui-panel title="Willkommen im Location Management" subtitle="Verwalte deine Standorte und Orte">
                <div class="p-6 text-center">
                    <div class="mb-4">
                        @svg('heroicon-o-map-pin', 'w-16 h-16 text-[var(--ui-primary)] mx-auto')
                    </div>
                    <h2 class="text-xl font-semibold text-[var(--ui-secondary)] mb-2">
                        Location Management
                    </h2>
                    <p class="text-[var(--ui-muted)]">
                        Hier kannst du in Zukunft deine Standorte verwalten.
                    </p>
                </div>
            </x-ui-panel>

            {{-- Placeholder Stats --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <x-ui-dashboard-tile
                    title="Standorte"
                    :count="0"
                    subtitle="Gesamt"
                    icon="map-pin"
                    variant="secondary"
                    size="lg"
                />
                <x-ui-dashboard-tile
                    title="Aktive Standorte"
                    :count="0"
                    subtitle="Aktiv"
                    icon="check-circle"
                    variant="secondary"
                    size="lg"
                />
                <x-ui-dashboard-tile
                    title="Regionen"
                    :count="0"
                    subtitle="Gesamt"
                    icon="globe-alt"
                    variant="secondary"
                    size="lg"
                />
                <x-ui-dashboard-tile
                    title="Letzte Aktualisierung"
                    :count="now()->format('d.m.Y')"
                    subtitle="Heute"
                    icon="clock"
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
                        <p class="text-sm text-[var(--ui-muted)]">
                            Funktionen werden in Kürze hinzugefügt.
                        </p>
                    </div>
                </div>

                {{-- Quick Stats --}}
                <div>
                    <h3 class="text-sm font-bold text-[var(--ui-secondary)] uppercase tracking-wider mb-3">Schnellstatistiken</h3>
                    <div class="space-y-3">
                        <div class="p-3 bg-[var(--ui-muted-5)] rounded-lg border border-[var(--ui-border)]/40">
                            <div class="text-xs text-[var(--ui-muted)]">Standorte</div>
                            <div class="text-lg font-bold text-[var(--ui-secondary)]">0</div>
                        </div>
                    </div>
                </div>
            </div>
        </x-ui-page-sidebar>
    </x-slot>
</x-ui-page>
