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
                    <x-ui-button variant="primary" size="sm" wire:click="openFilePicker">
                        <span class="inline-flex items-center gap-2">
                            @svg('heroicon-o-plus', 'w-4 h-4')
                            <span>Bilder hinzufuegen</span>
                        </span>
                    </x-ui-button>
                    <x-ui-button variant="secondary-outline" size="sm" :href="route('location.locations.show', $galleryBoard->location)" wire:navigate>
                        <span class="inline-flex items-center gap-2">
                            @svg('heroicon-o-arrow-left', 'w-4 h-4')
                            <span>Zurueck</span>
                        </span>
                    </x-ui-button>
                </div>
            </div>

            {{-- Gallery Grid --}}
            <x-ui-panel title="Galerie" :counter="count($items)">
                @if(count($items) > 0)
                    <div
                        x-data="{
                            items: @js($items),
                            dragging: null,
                            init() {
                                this.$watch('items', (value) => {
                                    // Items wurden aktualisiert
                                });
                            },
                            startDrag(event, index) {
                                this.dragging = index;
                                event.dataTransfer.effectAllowed = 'move';
                                event.dataTransfer.setData('text/plain', index);
                            },
                            onDragOver(event, index) {
                                event.preventDefault();
                                if (this.dragging === null || this.dragging === index) return;

                                const items = [...this.items];
                                const draggedItem = items[this.dragging];
                                items.splice(this.dragging, 1);
                                items.splice(index, 0, draggedItem);
                                this.items = items;
                                this.dragging = index;
                            },
                            endDrag() {
                                if (this.dragging !== null) {
                                    const orderedIds = this.items.map(item => item.id);
                                    $wire.updateItemOrder(orderedIds);
                                }
                                this.dragging = null;
                            }
                        }"
                        class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4"
                    >
                        <template x-for="(item, index) in items" :key="item.id">
                            <div
                                draggable="true"
                                @dragstart="startDrag($event, index)"
                                @dragover="onDragOver($event, index)"
                                @dragend="endDrag()"
                                class="relative group rounded-lg border border-[var(--ui-border)]/60 overflow-hidden bg-white cursor-move transition-all hover:shadow-md"
                                :class="{ 'opacity-50 scale-95': dragging === index }"
                            >
                                {{-- Image --}}
                                <template x-if="item.thumbnail">
                                    <a :href="item.url" target="_blank" class="block">
                                        <img
                                            :src="item.thumbnail"
                                            :alt="item.title"
                                            class="w-full aspect-square object-cover"
                                        />
                                    </a>
                                </template>
                                <template x-if="!item.thumbnail">
                                    <div class="w-full aspect-square bg-[var(--ui-muted-5)] flex items-center justify-center">
                                        @svg('heroicon-o-photo', 'w-12 h-12 text-[var(--ui-muted)]/50')
                                    </div>
                                </template>

                                {{-- Overlay with title --}}
                                <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent p-3">
                                    <p class="text-xs text-white truncate font-medium" x-text="item.title"></p>
                                </div>

                                {{-- Drag handle indicator --}}
                                <div class="absolute top-2 left-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <div class="w-6 h-6 rounded bg-black/40 flex items-center justify-center">
                                        @svg('heroicon-o-bars-3', 'w-4 h-4 text-white')
                                    </div>
                                </div>

                                {{-- Delete button --}}
                                <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button
                                        @click.prevent="$wire.deleteItem(item.id)"
                                        class="w-6 h-6 rounded bg-red-500 hover:bg-red-600 flex items-center justify-center transition-colors"
                                        title="Entfernen"
                                    >
                                        @svg('heroicon-o-x-mark', 'w-4 h-4 text-white')
                                    </button>
                                </div>

                                {{-- Order badge --}}
                                <div class="absolute bottom-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <span class="px-1.5 py-0.5 text-xs font-medium bg-black/50 text-white rounded" x-text="index + 1"></span>
                                </div>
                            </div>
                        </template>
                    </div>
                @else
                    <div class="p-8 text-center text-[var(--ui-muted)] bg-white rounded-md border border-dashed border-[var(--ui-border)]">
                        <div class="flex flex-col items-center gap-3">
                            @svg('heroicon-o-photo', 'w-12 h-12 text-green-300')
                            <p class="text-lg font-medium text-[var(--ui-secondary)]">Noch keine Bilder</p>
                            <p>Klicken Sie auf "Bilder hinzufuegen" um Bilder zur Galerie hinzuzufuegen.</p>
                            <x-ui-button variant="primary" size="sm" wire:click="openFilePicker" class="mt-2">
                                @svg('heroicon-o-plus', 'w-4 h-4 mr-1')
                                Bilder hinzufuegen
                            </x-ui-button>
                        </div>
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
                        <x-ui-button variant="primary" size="sm" wire:click="openFilePicker" class="w-full">
                            <span class="flex items-center gap-2">
                                @svg('heroicon-o-plus', 'w-4 h-4')
                                Bilder hinzufuegen
                            </span>
                        </x-ui-button>
                        <x-ui-button variant="secondary-outline" size="sm" wire:click="$dispatch('files:open')" class="w-full">
                            <span class="flex items-center gap-2">
                                @svg('heroicon-o-paper-clip', 'w-4 h-4')
                                Dateien verwalten
                            </span>
                        </x-ui-button>
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
                            <div class="text-xs text-[var(--ui-muted)]">Bilder</div>
                            <div class="text-sm font-medium text-[var(--ui-secondary)]">{{ count($items) }}</div>
                        </div>
                        <div class="p-3 bg-[var(--ui-muted-5)] rounded-lg border border-[var(--ui-border)]/40">
                            <div class="text-xs text-[var(--ui-muted)]">Erstellt am</div>
                            <div class="text-sm font-medium text-[var(--ui-secondary)]">{{ $galleryBoard->created_at->format('d.m.Y H:i') }}</div>
                        </div>
                    </div>
                </div>

                {{-- Help --}}
                <div>
                    <h3 class="text-sm font-bold text-[var(--ui-secondary)] uppercase tracking-wider mb-3">Hilfe</h3>
                    <div class="p-3 bg-blue-50 rounded-lg border border-blue-100">
                        <p class="text-xs text-blue-700">
                            <strong>Tipp:</strong> Bilder koennen per Drag & Drop neu sortiert werden.
                        </p>
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
