<x-ui-page>
    <x-slot name="navbar">
        <x-ui-page-navbar title="{{ $contentBoard->name }}" icon="heroicon-o-document-text" />
    </x-slot>

    <x-ui-page-container>
        <div class="space-y-6">
            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-2 text-sm text-[var(--ui-muted)]">
                <a href="{{ route('location.sites.index') }}" wire:navigate class="hover:text-[var(--ui-secondary)]">Sites</a>
                <span>/</span>
                <a href="{{ route('location.sites.locations', $contentBoard->location->site) }}" wire:navigate class="hover:text-[var(--ui-secondary)]">{{ $contentBoard->location->site->name }}</a>
                <span>/</span>
                <a href="{{ route('location.locations.show', $contentBoard->location) }}" wire:navigate class="hover:text-[var(--ui-secondary)]">{{ $contentBoard->location->name }}</a>
                <span>/</span>
                <span class="text-[var(--ui-secondary)]">{{ $contentBoard->name }}</span>
            </nav>

            {{-- Header --}}
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-3">
                        <h1 class="text-2xl font-bold text-[var(--ui-secondary)]">{{ $contentBoard->name }}</h1>
                        <span class="px-2 py-1 text-xs font-medium text-blue-700 bg-blue-50 rounded">Content Board</span>
                    </div>
                    @if($contentBoard->description)
                        <p class="text-[var(--ui-muted)] mt-1">{{ $contentBoard->description }}</p>
                    @endif
                </div>
                <div class="flex items-center gap-2">
                    <x-ui-button variant="primary" size="sm" wire:click="addItem">
                        <span class="inline-flex items-center gap-2">
                            @svg('heroicon-o-plus', 'w-4 h-4')
                            <span>Block hinzufuegen</span>
                        </span>
                    </x-ui-button>
                    <x-ui-button variant="secondary-outline" size="sm" :href="route('location.locations.show', $contentBoard->location)" wire:navigate>
                        <span class="inline-flex items-center gap-2">
                            @svg('heroicon-o-arrow-left', 'w-4 h-4')
                            <span>Zurueck zur Location</span>
                        </span>
                    </x-ui-button>
                </div>
            </div>

            {{-- Content Items --}}
            @if(count($items) > 0)
                <div
                    wire:sortable="updateItemOrder"
                    wire:sortable.options="{ animation: 150 }"
                    class="space-y-4"
                >
                    @foreach($items as $item)
                        <div
                            wire:sortable.item="{{ $item['id'] }}"
                            wire:key="item-{{ $item['id'] }}"
                            class="group"
                        >
                            <div class="flex items-start gap-2 py-2">
                                {{-- Drag Handle --}}
                                <div wire:sortable.handle class="cursor-move p-1 text-[var(--ui-muted)] hover:text-[var(--ui-primary)] flex-shrink-0 mt-1" title="Zum Verschieben ziehen">
                                    @svg('heroicon-o-bars-3', 'w-5 h-5')
                                </div>

                                {{-- Toast UI Editor --}}
                                <div class="flex-1 min-w-0" wire:ignore>
                                    <div
                                        x-data="{
                                            editor: null,
                                            debounceTimer: null,
                                            itemId: {{ $item['id'] }},
                                            initialContent: @js($item['content'] ?? ''),
                                            init() {
                                                const Editor = window.ToastUIEditor;
                                                if (!Editor) {
                                                    window.addEventListener('toastui:ready', () => this.bootEditor(), { once: true });
                                                    return;
                                                }
                                                this.bootEditor();
                                            },
                                            bootEditor() {
                                                const Editor = window.ToastUIEditor;
                                                if (!Editor) return;

                                                this.editor = new Editor({
                                                    el: this.$refs.editorEl,
                                                    height: 'auto',
                                                    minHeight: '100px',
                                                    initialEditType: 'wysiwyg',
                                                    previewStyle: 'tab',
                                                    hideModeSwitch: true,
                                                    usageStatistics: false,
                                                    placeholder: 'Inhalt eingeben...',
                                                    toolbarItems: [
                                                        ['heading', 'bold', 'italic', 'strike'],
                                                        ['ul', 'ol', 'task', 'quote'],
                                                        ['link', 'code', 'hr'],
                                                    ],
                                                    initialValue: this.initialContent || '',
                                                });

                                                this.editor.on('change', () => {
                                                    clearTimeout(this.debounceTimer);
                                                    this.debounceTimer = setTimeout(() => {
                                                        const content = this.editor.getMarkdown();
                                                        this.$wire.updateItemContent(this.itemId, content);
                                                    }, 900);
                                                });
                                            }
                                        }"
                                    >
                                        <div x-ref="editorEl"></div>
                                    </div>
                                </div>

                                {{-- Delete Button --}}
                                <button
                                    wire:click="deleteItem({{ $item['id'] }})"
                                    wire:confirm="Diesen Block wirklich loeschen?"
                                    class="opacity-0 group-hover:opacity-100 transition-opacity p-1 text-[var(--ui-danger)] hover:text-[var(--ui-danger-80)] flex-shrink-0 mt-1"
                                    title="Loeschen"
                                >
                                    @svg('heroicon-o-trash', 'w-4 h-4')
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-xl border border-[var(--ui-border)]/60 shadow-sm overflow-hidden">
                    <div class="p-8 text-center text-[var(--ui-muted)] border-2 border-dashed border-[var(--ui-border)]/40 rounded-xl bg-[var(--ui-muted-5)] m-4">
                        <div class="flex flex-col items-center gap-3">
                            @svg('heroicon-o-document-text', 'w-12 h-12 text-blue-300')
                            <p class="text-lg font-medium text-[var(--ui-secondary)]">Keine Bloecke vorhanden</p>
                            <p>Fuege deinen ersten Content-Block hinzu.</p>
                            <x-ui-button variant="primary" size="sm" wire:click="addItem" class="mt-2">
                                <span class="inline-flex items-center gap-2">
                                    @svg('heroicon-o-plus', 'w-4 h-4')
                                    <span>Ersten Block hinzufuegen</span>
                                </span>
                            </x-ui-button>
                        </div>
                    </div>
                </div>
            @endif
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
                        <x-ui-button variant="secondary-outline" size="sm" :href="route('location.locations.show', $contentBoard->location)" wire:navigate class="w-full">
                            <span class="flex items-center gap-2">
                                @svg('heroicon-o-map-pin', 'w-4 h-4')
                                {{ $contentBoard->location->name }}
                            </span>
                        </x-ui-button>
                    </div>
                </div>

                {{-- Board Info --}}
                <div>
                    <h3 class="text-sm font-bold text-[var(--ui-secondary)] uppercase tracking-wider mb-3">Board Info</h3>
                    <div class="space-y-3">
                        <div class="p-3 bg-blue-50 rounded-lg border border-blue-100">
                            <div class="text-xs text-blue-600">Typ</div>
                            <div class="text-sm font-medium text-blue-700">Content Board</div>
                        </div>
                        <div class="p-3 bg-[var(--ui-muted-5)] rounded-lg border border-[var(--ui-border)]/40">
                            <div class="text-xs text-[var(--ui-muted)]">Bloecke</div>
                            <div class="text-sm font-medium text-[var(--ui-secondary)]">{{ count($items) }}</div>
                        </div>
                        <div class="p-3 bg-[var(--ui-muted-5)] rounded-lg border border-[var(--ui-border)]/40">
                            <div class="text-xs text-[var(--ui-muted)]">Erstellt am</div>
                            <div class="text-sm font-medium text-[var(--ui-secondary)]">{{ $contentBoard->created_at->format('d.m.Y H:i') }}</div>
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
                        <div class="font-medium text-[var(--ui-secondary)] truncate">Content Board geoeffnet</div>
                        <div class="text-[var(--ui-muted)]">vor 1 Minute</div>
                    </div>
                </div>
            </div>
        </x-ui-page-sidebar>
    </x-slot>
</x-ui-page>
