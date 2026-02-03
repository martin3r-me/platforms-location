<x-ui-page>
    <x-slot name="navbar">
        <x-ui-page-navbar title="Standorte" icon="heroicon-o-map-pin" />
    </x-slot>

    <x-ui-page-container>
        <div class="space-y-6">
            {{-- Header --}}
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-[var(--ui-secondary)]">Standorte</h1>
                    <p class="text-[var(--ui-muted)] mt-1">Verwalte deine Standorte</p>
                </div>
                <x-ui-button variant="success" size="sm" x-data @click="$dispatch('open-modal-create-standort')">
                    <span class="inline-flex items-center gap-2">
                        @svg('heroicon-o-plus', 'w-4 h-4')
                        <span>Neuer Standort</span>
                    </span>
                </x-ui-button>
            </div>

            {{-- Standorte List --}}
            <x-ui-panel title="Standorte" :subtitle="count($standorte) . ' Standort(e)'">
                <div class="space-y-3">
                    @forelse($standorte as $standort)
                        <div class="p-4 rounded-md border border-[var(--ui-border)] bg-white hover:bg-[var(--ui-muted-5)] transition">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2">
                                        <h3 class="font-semibold text-[var(--ui-secondary)]">{{ $standort->name }}</h3>
                                        @if($standort->is_international)
                                            <span class="px-2 py-1 text-xs font-medium text-blue-700 bg-blue-100 rounded">International</span>
                                        @endif
                                    </div>
                                    @if($standort->description)
                                        <p class="text-sm text-[var(--ui-muted)] mt-1">{{ $standort->description }}</p>
                                    @endif
                                    
                                    {{-- Adresse --}}
                                    @if($standort->full_address)
                                        <div class="mt-2 text-sm text-[var(--ui-secondary)]">
                                            <span class="font-medium">Adresse:</span> {{ $standort->full_address }}
                                        </div>
                                    @endif
                                    
                                    {{-- GPS --}}
                                    @if($standort->latitude && $standort->longitude)
                                        <div class="mt-1 text-xs text-[var(--ui-muted)]">
                                            GPS: {{ number_format($standort->latitude, 6) }}, {{ number_format($standort->longitude, 6) }}
                                        </div>
                                    @endif
                                    
                                    {{-- Location --}}
                                    @if($standort->location)
                                        <div class="mt-1 text-xs text-[var(--ui-muted)]">
                                            Location: {{ $standort->location->name }}
                                        </div>
                                    @endif
                                    
                                    <div class="mt-2 flex items-center gap-4 text-xs text-[var(--ui-muted)]">
                                        @if($standort->country_code)
                                            <span>{{ $standort->country_code }}</span>
                                        @endif
                                        @if($standort->timezone)
                                            <span>{{ $standort->timezone }}</span>
                                        @endif
                                        <span>{{ $standort->created_at->format('d.m.Y') }}</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    @if($standort->is_active)
                                        <span class="px-2 py-1 text-xs font-medium text-green-700 bg-green-100 rounded">Aktiv</span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-medium text-gray-700 bg-gray-100 rounded">Inaktiv</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-[var(--ui-muted)] bg-white rounded-md border border-[var(--ui-border)]">
                            <p>Noch keine Standorte vorhanden.</p>
                        </div>
                    @endforelse
                </div>
            </x-ui-panel>
        </div>
    </x-ui-page-container>

    <x-slot name="sidebar">
        <x-ui-page-sidebar title="Schnellzugriff" width="w-80" :defaultOpen="true">
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
                            <div class="text-xs text-[var(--ui-muted)]">Standorte</div>
                            <div class="text-lg font-bold text-[var(--ui-secondary)]">{{ count($standorte) }}</div>
                        </div>
                        <div class="p-3 bg-[var(--ui-muted-5)] rounded-lg border border-[var(--ui-border)]/40">
                            <div class="text-xs text-[var(--ui-muted)]">International</div>
                            <div class="text-lg font-bold text-[var(--ui-secondary)]">{{ $internationalCount ?? 0 }}</div>
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
                        <div class="font-medium text-[var(--ui-secondary)] truncate">Standorte-Übersicht geladen</div>
                        <div class="text-[var(--ui-muted)]">vor 1 Minute</div>
                    </div>
                </div>
            </div>
        </x-ui-page-sidebar>
    </x-slot>

    {{-- Modals innerhalb des Page-Roots halten (ein Root-Element) --}}
    <livewire:location.create-standort-modal />
</x-ui-page>
