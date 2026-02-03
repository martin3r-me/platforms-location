<x-ui-page>
    <x-slot name="navbar">
        <x-ui-page-navbar title="{{ $location->name }}" icon="heroicon-o-map-pin" />
    </x-slot>

    <x-ui-page-container>
        <div class="space-y-6">
            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-2 text-sm text-[var(--ui-muted)]">
                <a href="{{ route('location.sites.index') }}" wire:navigate class="hover:text-[var(--ui-secondary)]">Sites</a>
                <span>/</span>
                <a href="{{ route('location.sites.locations', $location->site) }}" wire:navigate class="hover:text-[var(--ui-secondary)]">{{ $location->site->name }}</a>
                <span>/</span>
                <span class="text-[var(--ui-secondary)]">{{ $location->name }}</span>
            </nav>

            {{-- Header --}}
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-[var(--ui-secondary)]">{{ $location->name }}</h1>
                    @if($location->description)
                        <p class="text-[var(--ui-muted)] mt-1">{{ $location->description }}</p>
                    @endif
                </div>
                <div class="flex items-center gap-2">
                    <x-ui-button variant="secondary-outline" size="sm" :href="route('location.sites.locations', $location->site)" wire:navigate>
                        <span class="inline-flex items-center gap-2">
                            @svg('heroicon-o-arrow-left', 'w-4 h-4')
                            <span>Zurueck</span>
                        </span>
                    </x-ui-button>
                    <div x-data="{ open: false }" class="relative">
                        <x-ui-button variant="success" size="sm" @click="open = !open">
                            <span class="inline-flex items-center gap-2">
                                @svg('heroicon-o-plus', 'w-4 h-4')
                                <span>Board erstellen</span>
                                @svg('heroicon-o-chevron-down', 'w-4 h-4')
                            </span>
                        </x-ui-button>
                        <div x-show="open" @click.outside="open = false" x-transition
                            class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-[var(--ui-border)] z-50">
                            <button wire:click="createContentBoard" class="w-full px-4 py-2 text-left text-sm hover:bg-[var(--ui-muted-5)] rounded-t-lg flex items-center gap-2">
                                @svg('heroicon-o-document-text', 'w-4 h-4 text-blue-600')
                                <span>Content Board</span>
                            </button>
                            <button wire:click="createGalleryBoard" class="w-full px-4 py-2 text-left text-sm hover:bg-[var(--ui-muted-5)] rounded-b-lg flex items-center gap-2">
                                @svg('heroicon-o-photo', 'w-4 h-4 text-green-600')
                                <span>Gallery Board</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Content Boards Section --}}
            <x-ui-panel title="Content Boards" :subtitle="count($contentBoards) . ' Board(s)'">
                @if($contentBoards->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                        @foreach($contentBoards as $board)
                            <a href="{{ route('location.content-boards.show', $board) }}" wire:navigate class="group block">
                                <div class="bg-white rounded-xl border border-[var(--ui-border)] p-4 hover:shadow-md hover:border-blue-300 transition-all">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-[var(--ui-secondary)] group-hover:text-blue-600 transition-colors">{{ $board->name }}</h4>
                                            @if($board->description)
                                                <p class="text-sm text-[var(--ui-muted)] mt-1 line-clamp-2">{{ $board->description }}</p>
                                            @endif
                                        </div>
                                        @svg('heroicon-o-document-text', 'w-5 h-5 text-blue-600 flex-shrink-0 ml-2')
                                    </div>
                                    <div class="mt-3 flex items-center gap-2">
                                        <span class="px-2 py-1 text-xs font-medium text-blue-700 bg-blue-50 rounded">Content Board</span>
                                        @if($board->done)
                                            <span class="px-2 py-1 text-xs font-medium text-green-700 bg-green-100 rounded">Erledigt</span>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="p-6 text-center text-[var(--ui-muted)] bg-white rounded-md border border-[var(--ui-border)]">
                        <p>Noch keine Content Boards vorhanden.</p>
                    </div>
                @endif
            </x-ui-panel>

            {{-- Gallery Boards Section --}}
            <x-ui-panel title="Gallery Boards" :subtitle="count($galleryBoards) . ' Board(s)'">
                @if($galleryBoards->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                        @foreach($galleryBoards as $board)
                            <a href="{{ route('location.gallery-boards.show', $board) }}" wire:navigate class="group block">
                                <div class="bg-white rounded-xl border border-[var(--ui-border)] p-4 hover:shadow-md hover:border-green-300 transition-all">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-[var(--ui-secondary)] group-hover:text-green-600 transition-colors">{{ $board->name }}</h4>
                                            @if($board->description)
                                                <p class="text-sm text-[var(--ui-muted)] mt-1 line-clamp-2">{{ $board->description }}</p>
                                            @endif
                                        </div>
                                        @svg('heroicon-o-photo', 'w-5 h-5 text-green-600 flex-shrink-0 ml-2')
                                    </div>
                                    <div class="mt-3 flex items-center gap-2">
                                        <span class="px-2 py-1 text-xs font-medium text-green-700 bg-green-50 rounded">Gallery Board</span>
                                        @if($board->done)
                                            <span class="px-2 py-1 text-xs font-medium text-green-700 bg-green-100 rounded">Erledigt</span>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="p-6 text-center text-[var(--ui-muted)] bg-white rounded-md border border-[var(--ui-border)]">
                        <p>Noch keine Gallery Boards vorhanden.</p>
                    </div>
                @endif
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
                        <x-ui-button variant="secondary-outline" size="sm" :href="route('location.sites.locations', $location->site)" wire:navigate class="w-full">
                            <span class="flex items-center gap-2">
                                @svg('heroicon-o-map-pin', 'w-4 h-4')
                                Alle Locations
                            </span>
                        </x-ui-button>
                    </div>
                </div>

                {{-- Quick Stats --}}
                <div>
                    <h3 class="text-sm font-bold text-[var(--ui-secondary)] uppercase tracking-wider mb-3">Statistiken</h3>
                    <div class="space-y-3">
                        <div class="p-3 bg-blue-50 rounded-lg border border-blue-100">
                            <div class="text-xs text-blue-600">Content Boards</div>
                            <div class="text-lg font-bold text-blue-700">{{ count($contentBoards) }}</div>
                        </div>
                        <div class="p-3 bg-green-50 rounded-lg border border-green-100">
                            <div class="text-xs text-green-600">Gallery Boards</div>
                            <div class="text-lg font-bold text-green-700">{{ count($galleryBoards) }}</div>
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
                        <div class="font-medium text-[var(--ui-secondary)] truncate">Location geoeffnet</div>
                        <div class="text-[var(--ui-muted)]">vor 1 Minute</div>
                    </div>
                </div>
            </div>
        </x-ui-page-sidebar>
    </x-slot>
</x-ui-page>
