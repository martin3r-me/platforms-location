<x-ui-page>
    <x-slot name="navbar">
        <x-ui-page-navbar title="{{ $pricingBoard->name }}" icon="heroicon-o-banknotes" />
    </x-slot>

    <x-ui-page-container>
        <div class="space-y-6">
            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-2 text-sm text-[var(--ui-muted)]">
                <a href="{{ route('location.sites.index') }}" wire:navigate class="hover:text-[var(--ui-secondary)]">Sites</a>
                <span>/</span>
                <a href="{{ route('location.sites.locations', $pricingBoard->location->site) }}" wire:navigate class="hover:text-[var(--ui-secondary)]">{{ $pricingBoard->location->site->name }}</a>
                <span>/</span>
                <a href="{{ route('location.locations.show', $pricingBoard->location) }}" wire:navigate class="hover:text-[var(--ui-secondary)]">{{ $pricingBoard->location->name }}</a>
                <span>/</span>
                <span class="text-[var(--ui-secondary)]">{{ $pricingBoard->name }}</span>
            </nav>

            {{-- Header --}}
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-3">
                        <h1 class="text-2xl font-bold text-[var(--ui-secondary)]">{{ $pricingBoard->name }}</h1>
                        <span class="px-2 py-1 text-xs font-medium text-amber-700 bg-amber-50 rounded">Pricing Board</span>
                        @if($pricingBoard->done)
                            <span class="px-2 py-1 text-xs font-medium text-green-700 bg-green-100 rounded">Erledigt</span>
                        @endif
                    </div>
                    @if($pricingBoard->description)
                        <p class="text-[var(--ui-muted)] mt-1">{{ $pricingBoard->description }}</p>
                    @endif
                </div>
                <div class="flex items-center gap-2">
                    <x-ui-button variant="primary" size="sm" wire:click="save">
                        <span class="inline-flex items-center gap-2">
                            @svg('heroicon-o-check', 'w-4 h-4')
                            <span>Speichern</span>
                        </span>
                    </x-ui-button>
                    <x-ui-button variant="secondary-outline" size="sm" :href="route('location.locations.show', $pricingBoard->location)" wire:navigate>
                        <span class="inline-flex items-center gap-2">
                            @svg('heroicon-o-arrow-left', 'w-4 h-4')
                            <span>Zurueck zur Location</span>
                        </span>
                    </x-ui-button>
                </div>
            </div>

            @if(session('success'))
                <div class="p-3 bg-green-50 border border-green-200 rounded-lg text-green-700 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Allgemeine Informationen --}}
            <x-ui-panel title="Allgemeine Informationen">
                <div class="p-4 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-[var(--ui-secondary)] mb-1">Name</label>
                            <input type="text" wire:model.blur="name" wire:change="updateField('name', $event.target.value)"
                                class="w-full px-3 py-2 border border-[var(--ui-border)] rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500" />
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-[var(--ui-secondary)] mb-1">Beschreibung</label>
                        <textarea wire:model.blur="description" wire:change="updateField('description', $event.target.value)"
                            rows="2"
                            class="w-full px-3 py-2 border border-[var(--ui-border)] rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500"
                            placeholder="Optionale Beschreibung..."></textarea>
                    </div>
                </div>
            </x-ui-panel>

            {{-- Mietpreise --}}
            <x-ui-panel title="Mietpreise">
                <div class="p-4 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-[var(--ui-secondary)] mb-1">Mietpreis Aufbautag</label>
                            <input type="number" step="0.01" wire:model.blur="mietpreis_aufbautag" wire:change="updateField('mietpreis_aufbautag', $event.target.value)"
                                class="w-full px-3 py-2 border border-[var(--ui-border)] rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500"
                                placeholder="0.00" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[var(--ui-secondary)] mb-1">Mietpreis Abbautag</label>
                            <input type="number" step="0.01" wire:model.blur="mietpreis_abbautag" wire:change="updateField('mietpreis_abbautag', $event.target.value)"
                                class="w-full px-3 py-2 border border-[var(--ui-border)] rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500"
                                placeholder="0.00" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[var(--ui-secondary)] mb-1">Mietpreis VA-Tag</label>
                            <input type="number" step="0.01" wire:model.blur="mietpreis_va_tag" wire:change="updateField('mietpreis_va_tag', $event.target.value)"
                                class="w-full px-3 py-2 border border-[var(--ui-border)] rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500"
                                placeholder="0.00" />
                        </div>
                    </div>
                </div>
            </x-ui-panel>

            {{-- Gueltigkeit --}}
            <x-ui-panel title="Gueltigkeit">
                <div class="p-4 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-[var(--ui-secondary)] mb-1">Gueltig ab</label>
                            <input type="date" wire:model.blur="valid_from" wire:change="updateField('valid_from', $event.target.value)"
                                class="w-full px-3 py-2 border border-[var(--ui-border)] rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[var(--ui-secondary)] mb-1">Gueltig bis (optional)</label>
                            <input type="date" wire:model.blur="valid_to" wire:change="updateField('valid_to', $event.target.value)"
                                class="w-full px-3 py-2 border border-[var(--ui-border)] rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500" />
                        </div>
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
                        <x-ui-button variant="secondary-outline" size="sm" :href="route('location.locations.show', $pricingBoard->location)" wire:navigate class="w-full">
                            <span class="flex items-center gap-2">
                                @svg('heroicon-o-map-pin', 'w-4 h-4')
                                {{ $pricingBoard->location->name }}
                            </span>
                        </x-ui-button>
                    </div>
                </div>

                {{-- Board Info --}}
                <div>
                    <h3 class="text-sm font-bold text-[var(--ui-secondary)] uppercase tracking-wider mb-3">Board Info</h3>
                    <div class="space-y-3">
                        <div class="p-3 bg-amber-50 rounded-lg border border-amber-100">
                            <div class="text-xs text-amber-600">Typ</div>
                            <div class="text-sm font-medium text-amber-700">Pricing Board</div>
                        </div>
                        <div class="p-3 bg-[var(--ui-muted-5)] rounded-lg border border-[var(--ui-border)]/40">
                            <div class="text-xs text-[var(--ui-muted)]">Erledigt</div>
                            <div class="flex items-center gap-2 mt-1">
                                <button wire:click="toggleDone" class="text-sm font-medium {{ $pricingBoard->done ? 'text-green-600' : 'text-[var(--ui-secondary)]' }}">
                                    @if($pricingBoard->done)
                                        @svg('heroicon-s-check-circle', 'w-5 h-5 text-green-500 inline')
                                        <span>Erledigt</span>
                                    @else
                                        @svg('heroicon-o-circle-stack', 'w-5 h-5 text-gray-400 inline')
                                        <span>Offen</span>
                                    @endif
                                </button>
                            </div>
                            @if($pricingBoard->done && $pricingBoard->done_at)
                                <div class="text-xs text-[var(--ui-muted)] mt-1">{{ $pricingBoard->done_at->format('d.m.Y H:i') }}</div>
                            @endif
                        </div>
                        <div class="p-3 bg-[var(--ui-muted-5)] rounded-lg border border-[var(--ui-border)]/40">
                            <div class="text-xs text-[var(--ui-muted)]">Erstellt am</div>
                            <div class="text-sm font-medium text-[var(--ui-secondary)]">{{ $pricingBoard->created_at->format('d.m.Y H:i') }}</div>
                        </div>
                        @if($pricingBoard->valid_from || $pricingBoard->valid_to)
                            <div class="p-3 bg-[var(--ui-muted-5)] rounded-lg border border-[var(--ui-border)]/40">
                                <div class="text-xs text-[var(--ui-muted)]">Gueltigkeit</div>
                                <div class="text-sm font-medium text-[var(--ui-secondary)]">
                                    {{ $pricingBoard->valid_from ? $pricingBoard->valid_from->format('d.m.Y') : '–' }}
                                    –
                                    {{ $pricingBoard->valid_to ? $pricingBoard->valid_to->format('d.m.Y') : 'unbegrenzt' }}
                                </div>
                            </div>
                        @endif
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
                        <div class="font-medium text-[var(--ui-secondary)] truncate">Pricing Board geoeffnet</div>
                        <div class="text-[var(--ui-muted)]">vor 1 Minute</div>
                    </div>
                </div>
            </div>
        </x-ui-page-sidebar>
    </x-slot>
</x-ui-page>
