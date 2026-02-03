<x-ui-page>
    <x-slot name="navbar">
        <x-ui-page-navbar title="{{ $galleryBoard->name }}" icon="heroicon-o-photo" />
    </x-slot>

    <x-ui-page-container>
        <div class="space-y-6">
            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-2 text-sm text-[var(--ui-muted)]">
                <a href="{{ route('location.sites.index') }}" wire:navigate class="hover:text-[var(--ui-secondary)]">Sites</a>
                <span>/</span>
                <a href="{{ route('location.sites.locations', $galleryBoard->location->site) }}" wire:navigate class="hover:text-[var(--ui-secondary)]">{{ $galleryBoard->location->site->name }}</a>
                <span>/</span>
                <a href="{{ route('location.locations.show', $galleryBoard->location) }}" wire:navigate class="hover:text-[var(--ui-secondary)]">{{ $galleryBoard->location->name }}</a>
                <span>/</span>
                <span class="text-[var(--ui-secondary)]">{{ $galleryBoard->name }}</span>
            </nav>

            {{-- Header --}}
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-3">
                        <h1 class="text-2xl font-bold text-[var(--ui-secondary)]">{{ $galleryBoard->name }}</h1>
                        <span class="px-2 py-1 text-xs font-medium text-green-700 bg-green-50 rounded">Gallery Board</span>
                    </div>
                    @if($galleryBoard->description)
                        <p class="text-[var(--ui-muted)] mt-1">{{ $galleryBoard->description }}</p>
                    @endif
                </div>
                <div class="flex items-center gap-2">
                    <x-ui-button variant="secondary-outline" size="sm" :href="route('location.locations.show', $galleryBoard->location)" wire:navigate>
                        <span class="inline-flex items-center gap-2">
                            @svg('heroicon-o-arrow-left', 'w-4 h-4')
                            <span>Zurueck zur Location</span>
                        </span>
                    </x-ui-button>
                </div>
            </div>

            {{-- Gallery Placeholder --}}
            <x-ui-panel title="Galerie">
                <div class="p-8 text-center text-[var(--ui-muted)] bg-white rounded-md border border-dashed border-[var(--ui-border)]">
                    <div class="flex flex-col items-center gap-3">
                        @svg('heroicon-o-photo', 'w-12 h-12 text-green-300')
                        <p class="text-lg font-medium text-[var(--ui-secondary)]">Gallery Board</p>
                        <p>Hier werden die Bilder der Galerie angezeigt.</p>
                        <p class="text-sm">Bilder koennen hier hochgeladen und verwaltet werden.</p>
                    </div>
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
                        <x-ui-button variant="secondary-outline" size="sm" :href="route('location.locations.show', $galleryBoard->location)" wire:navigate class="w-full">
                            <span class="flex items-center gap-2">
                                @svg('heroicon-o-map-pin', 'w-4 h-4')
                                {{ $galleryBoard->location->name }}
                            </span>
                        </x-ui-button>
                    </div>
                </div>

                {{-- Board Info --}}
                <div>
                    <h3 class="text-sm font-bold text-[var(--ui-secondary)] uppercase tracking-wider mb-3">Board Info</h3>
                    <div class="space-y-3">
                        <div class="p-3 bg-green-50 rounded-lg border border-green-100">
                            <div class="text-xs text-green-600">Typ</div>
                            <div class="text-sm font-medium text-green-700">Gallery Board</div>
                        </div>
                        <div class="p-3 bg-[var(--ui-muted-5)] rounded-lg border border-[var(--ui-border)]/40">
                            <div class="text-xs text-[var(--ui-muted)]">Erstellt am</div>
                            <div class="text-sm font-medium text-[var(--ui-secondary)]">{{ $galleryBoard->created_at->format('d.m.Y H:i') }}</div>
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
                        <div class="font-medium text-[var(--ui-secondary)] truncate">Gallery Board geoeffnet</div>
                        <div class="text-[var(--ui-muted)]">vor 1 Minute</div>
                    </div>
                </div>
            </div>
        </x-ui-page-sidebar>
    </x-slot>
</x-ui-page>
