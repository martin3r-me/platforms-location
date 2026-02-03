<x-ui-page>
    <x-slot name="navbar">
        <x-ui-page-navbar title="Sites" icon="heroicon-o-globe-alt" />
    </x-slot>

    <x-ui-page-container>
        <div class="space-y-6">
            {{-- Header --}}
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-[var(--ui-secondary)]">Sites</h1>
                    <p class="text-[var(--ui-muted)] mt-1">Verwalte deine Sites</p>
                </div>
                <x-ui-button variant="success" size="sm" x-data @click="$dispatch('open-modal-create-site')">
                    <span class="inline-flex items-center gap-2">
                        @svg('heroicon-o-plus', 'w-4 h-4')
                        <span>Neue Site</span>
                    </span>
                </x-ui-button>
            </div>

            {{-- Sites List --}}
            <x-ui-panel title="Sites" :subtitle="count($sites) . ' Site(s)'">
                <div class="space-y-3">
                    @forelse($sites as $site)
                        <a href="{{ route('location.sites.locations', $site) }}" wire:navigate class="block p-4 rounded-md border border-[var(--ui-border)] bg-white hover:bg-[var(--ui-muted-5)] hover:border-[var(--ui-secondary)]/30 transition cursor-pointer">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2">
                                        <h3 class="font-semibold text-[var(--ui-secondary)]">{{ $site->name }}</h3>
                                        @if($site->is_international)
                                            <span class="px-2 py-1 text-xs font-medium text-blue-700 bg-blue-100 rounded">International</span>
                                        @endif
                                    </div>
                                    @if($site->description)
                                        <p class="text-sm text-[var(--ui-muted)] mt-1">{{ $site->description }}</p>
                                    @endif

                                    {{-- Address --}}
                                    @if($site->full_address)
                                        <div class="mt-2 text-sm text-[var(--ui-muted)]">
                                            <span class="font-medium">Adresse:</span> {{ $site->full_address }}
                                        </div>
                                    @endif

                                    {{-- GPS --}}
                                    @if($site->latitude && $site->longitude)
                                        <div class="mt-1 text-xs text-[var(--ui-muted)]">
                                            GPS: {{ number_format($site->latitude, 6) }}, {{ number_format($site->longitude, 6) }}
                                        </div>
                                    @endif

                                    <div class="mt-2 flex items-center gap-4 text-xs text-[var(--ui-muted)]">
                                        <span class="font-medium text-[var(--ui-secondary)]">{{ $site->locations_count }} Location(s)</span>
                                        @if($site->country_code)
                                            <span>{{ $site->country_code }}</span>
                                        @endif
                                        @if($site->timezone)
                                            <span>{{ $site->timezone }}</span>
                                        @endif
                                        <span>{{ $site->created_at->format('d.m.Y') }}</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    @if($site->done)
                                        <span class="px-2 py-1 text-xs font-medium text-green-700 bg-green-100 rounded">Erledigt</span>
                                    @endif
                                    @svg('heroicon-o-chevron-right', 'w-5 h-5 text-[var(--ui-muted)]')
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="p-6 text-center text-[var(--ui-muted)] bg-white rounded-md border border-[var(--ui-border)]">
                            <p>Noch keine Sites vorhanden.</p>
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
                    </div>
                </div>

                {{-- Quick Stats --}}
                <div>
                    <h3 class="text-sm font-bold text-[var(--ui-secondary)] uppercase tracking-wider mb-3">Schnellstatistiken</h3>
                    <div class="space-y-3">
                        <div class="p-3 bg-[var(--ui-muted-5)] rounded-lg border border-[var(--ui-border)]/40">
                            <div class="text-xs text-[var(--ui-muted)]">Sites</div>
                            <div class="text-lg font-bold text-[var(--ui-secondary)]">{{ count($sites) }}</div>
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
                        <div class="font-medium text-[var(--ui-secondary)] truncate">Sites-Übersicht geladen</div>
                        <div class="text-[var(--ui-muted)]">vor 1 Minute</div>
                    </div>
                </div>
            </div>
        </x-ui-page-sidebar>
    </x-slot>

    {{-- Modals --}}
    <livewire:location.create-site-modal />
</x-ui-page>
