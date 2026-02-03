<x-ui-page>
    <x-slot name="navbar">
        <x-ui-page-navbar title="Locations" icon="heroicon-o-map-pin" />
    </x-slot>

    <x-ui-page-container>
        <div class="space-y-6">
            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-2 text-sm text-[var(--ui-muted)]">
                <a href="{{ route('location.sites.index') }}" wire:navigate class="hover:text-[var(--ui-secondary)]">Sites</a>
                <span>/</span>
                <span class="text-[var(--ui-secondary)]">{{ $site->name }}</span>
            </nav>

            {{-- Header --}}
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-[var(--ui-secondary)]">{{ $site->name }}</h1>
                    <p class="text-[var(--ui-muted)] mt-1">Locations dieser Site</p>
                </div>
                <div class="flex items-center gap-2">
                    <x-ui-button variant="secondary-outline" size="sm" :href="route('location.sites.index')" wire:navigate>
                        <span class="inline-flex items-center gap-2">
                            @svg('heroicon-o-arrow-left', 'w-4 h-4')
                            <span>Zurück</span>
                        </span>
                    </x-ui-button>
                    <x-ui-button variant="success" size="sm" x-data @click="$dispatch('open-modal-create-location', { siteId: {{ $site->id }} })">
                        <span class="inline-flex items-center gap-2">
                            @svg('heroicon-o-plus', 'w-4 h-4')
                            <span>Neue Location</span>
                        </span>
                    </x-ui-button>
                </div>
            </div>

            {{-- Site Info --}}
            <div class="p-4 rounded-md border border-[var(--ui-border)] bg-[var(--ui-muted-5)]">
                <div class="flex items-center gap-2">
                    @svg('heroicon-o-globe-alt', 'w-5 h-5 text-[var(--ui-secondary)]')
                    <span class="font-semibold text-[var(--ui-secondary)]">{{ $site->name }}</span>
                    @if($site->is_international)
                        <span class="px-2 py-1 text-xs font-medium text-blue-700 bg-blue-100 rounded">International</span>
                    @endif
                </div>
                @if($site->full_address)
                    <p class="mt-1 text-sm text-[var(--ui-muted)]">{{ $site->full_address }}</p>
                @endif
            </div>

            {{-- Locations List --}}
            <x-ui-panel title="Locations" :subtitle="count($locations) . ' Location(s)'">
                <div class="space-y-3">
                    @forelse($locations as $location)
                        <a href="{{ route('location.locations.show', $location) }}" wire:navigate class="block p-4 rounded-md border border-[var(--ui-border)] bg-white hover:bg-[var(--ui-muted-5)] hover:border-[var(--ui-secondary)]/30 transition group">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2">
                                        <h3 class="font-semibold text-[var(--ui-secondary)] group-hover:text-[var(--ui-primary)]">{{ $location->name }}</h3>
                                    </div>
                                    @if($location->description)
                                        <p class="text-sm text-[var(--ui-muted)] mt-1">{{ $location->description }}</p>
                                    @endif

                                    <div class="mt-2 flex items-center gap-4 text-xs text-[var(--ui-muted)]">
                                        <span>{{ $location->created_at->format('d.m.Y') }}</span>
                                        @php
                                            $contentBoardCount = $location->contentBoards()->count();
                                            $galleryBoardCount = $location->galleryBoards()->count();
                                            $totalBoardCount = $contentBoardCount + $galleryBoardCount;
                                        @endphp
                                        @if($totalBoardCount > 0)
                                            <span class="flex items-center gap-1">
                                                @svg('heroicon-o-squares-2x2', 'w-3 h-3')
                                                {{ $totalBoardCount }} Board(s)
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    @if($location->done)
                                        <span class="px-2 py-1 text-xs font-medium text-green-700 bg-green-100 rounded">Erledigt</span>
                                    @endif
                                    @svg('heroicon-o-chevron-right', 'w-5 h-5 text-[var(--ui-muted)] group-hover:text-[var(--ui-secondary)]')
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="p-6 text-center text-[var(--ui-muted)] bg-white rounded-md border border-[var(--ui-border)]">
                            <p>Noch keine Locations in dieser Site vorhanden.</p>
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
                        <x-ui-button variant="secondary-outline" size="sm" :href="route('location.sites.index')" wire:navigate class="w-full">
                            <span class="flex items-center gap-2">
                                @svg('heroicon-o-globe-alt', 'w-4 h-4')
                                Alle Sites
                            </span>
                        </x-ui-button>
                    </div>
                </div>

                {{-- Quick Stats --}}
                <div>
                    <h3 class="text-sm font-bold text-[var(--ui-secondary)] uppercase tracking-wider mb-3">Schnellstatistiken</h3>
                    <div class="space-y-3">
                        <div class="p-3 bg-[var(--ui-muted-5)] rounded-lg border border-[var(--ui-border)]/40">
                            <div class="text-xs text-[var(--ui-muted)]">Locations in dieser Site</div>
                            <div class="text-lg font-bold text-[var(--ui-secondary)]">{{ count($locations) }}</div>
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
                <div class="space-y-3 text-sm">
                    <div class="p-2 rounded border border-[var(--ui-border)]/60 bg-[var(--ui-muted-5)]">
                        <div class="font-medium text-[var(--ui-secondary)] truncate">Site-Locations geladen</div>
                        <div class="text-[var(--ui-muted)]">vor 1 Minute</div>
                    </div>
                </div>
            </div>
        </x-ui-page-sidebar>
    </x-slot>

    {{-- Modals --}}
    <livewire:location.create-location-modal />
</x-ui-page>
