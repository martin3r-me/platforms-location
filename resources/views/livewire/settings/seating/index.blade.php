<x-ui-page>
    <x-slot name="navbar">
        <x-ui-page-navbar title="Bestuhlungen" icon="heroicon-o-square-3-stack-3d" />
    </x-slot>

    <x-ui-page-container>
        <div class="space-y-6">
            {{-- Header --}}
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-[var(--ui-secondary)]">Bestuhlungen</h1>
                    <p class="text-[var(--ui-muted)] mt-1">Bestuhlungsmoeglichkeiten verwalten</p>
                </div>
                <x-ui-button variant="success" size="sm" :href="route('location.settings.seatings.create')" wire:navigate>
                    <span class="inline-flex items-center gap-2">
                        @svg('heroicon-o-plus', 'w-4 h-4')
                        <span>Neue Bestuhlung</span>
                    </span>
                </x-ui-button>
            </div>

            {{-- Seatings List --}}
            <x-ui-panel title="Bestuhlungen" :subtitle="count($seatings) . ' Bestuhlung(en)'">
                <div class="space-y-3">
                    @forelse($seatings as $seating)
                        <div class="flex items-center justify-between p-4 rounded-md border border-[var(--ui-border)] bg-white hover:bg-[var(--ui-muted-5)] transition">
                            <div class="flex-1">
                                <div class="flex items-center gap-2">
                                    <h3 class="font-semibold text-[var(--ui-secondary)]">{{ $seating->name }}</h3>
                                    @if($seating->is_active)
                                        <span class="px-2 py-0.5 text-xs font-medium text-green-700 bg-green-100 rounded">Aktiv</span>
                                    @else
                                        <span class="px-2 py-0.5 text-xs font-medium text-gray-500 bg-gray-100 rounded">Inaktiv</span>
                                    @endif
                                </div>
                                @if($seating->description)
                                    <p class="text-sm text-[var(--ui-muted)] mt-1">{{ $seating->description }}</p>
                                @endif
                                <div class="mt-2 text-xs text-[var(--ui-muted)]">
                                    Erstellt {{ $seating->created_at->format('d.m.Y') }}
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <x-ui-button variant="secondary-outline" size="xs" :href="route('location.settings.seatings.edit', $seating)" wire:navigate>
                                    @svg('heroicon-o-pencil-square', 'w-4 h-4')
                                </x-ui-button>
                                <x-ui-button variant="danger-outline" size="xs" wire:click="delete({{ $seating->id }})" wire:confirm="Bestuhlung wirklich loeschen?">
                                    @svg('heroicon-o-trash', 'w-4 h-4')
                                </x-ui-button>
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-[var(--ui-muted)] bg-white rounded-md border border-[var(--ui-border)]">
                            <p>Noch keine Bestuhlungen vorhanden.</p>
                        </div>
                    @endforelse
                </div>
            </x-ui-panel>
        </div>
    </x-ui-page-container>

    <x-slot name="sidebar">
        <x-ui-page-sidebar title="Quick Access" width="w-80" :defaultOpen="true">
            <div class="p-6 space-y-6">
                {{-- Quick Actions --}}
                <div>
                    <h3 class="text-sm font-bold text-[var(--ui-secondary)] uppercase tracking-wider mb-3">Aktionen</h3>
                    <div class="space-y-2">
                        <x-ui-button variant="secondary-outline" size="sm" :href="route('location.dashboard')" wire:navigate class="w-full">
                            <span class="flex items-center gap-2">
                                @svg('heroicon-o-home', 'w-4 h-4')
                                Dashboard
                            </span>
                        </x-ui-button>
                    </div>
                </div>

                {{-- Quick Stats --}}
                <div>
                    <h3 class="text-sm font-bold text-[var(--ui-secondary)] uppercase tracking-wider mb-3">Statistiken</h3>
                    <div class="space-y-3">
                        <div class="p-3 bg-[var(--ui-muted-5)] rounded-lg border border-[var(--ui-border)]/40">
                            <div class="text-xs text-[var(--ui-muted)]">Gesamt</div>
                            <div class="text-lg font-bold text-[var(--ui-secondary)]">{{ count($seatings) }}</div>
                        </div>
                        <div class="p-3 bg-[var(--ui-muted-5)] rounded-lg border border-[var(--ui-border)]/40">
                            <div class="text-xs text-[var(--ui-muted)]">Aktiv</div>
                            <div class="text-lg font-bold text-[var(--ui-secondary)]">{{ $seatings->where('is_active', true)->count() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </x-ui-page-sidebar>
    </x-slot>

    <x-slot name="activity">
        <x-ui-page-sidebar title="Aktivitaeten" width="w-80" :defaultOpen="false" storeKey="activityOpen" side="right">
            <div class="p-4 space-y-4">
                <div class="text-sm text-[var(--ui-muted)]">Letzte Aktivitaeten</div>
            </div>
        </x-ui-page-sidebar>
    </x-slot>
</x-ui-page>
