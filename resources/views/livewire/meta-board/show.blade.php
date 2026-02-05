<x-ui-page>
    <x-slot name="navbar">
        <x-ui-page-navbar title="{{ $metaBoard->name }}" icon="heroicon-o-clipboard-document-list" />
    </x-slot>

    <x-ui-page-container>
        <div class="space-y-6">
            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-2 text-sm text-[var(--ui-muted)]">
                <a href="{{ route('location.sites.index') }}" wire:navigate class="hover:text-[var(--ui-secondary)]">Sites</a>
                <span>/</span>
                <a href="{{ route('location.sites.locations', $metaBoard->location->site) }}" wire:navigate class="hover:text-[var(--ui-secondary)]">{{ $metaBoard->location->site->name }}</a>
                <span>/</span>
                <a href="{{ route('location.locations.show', $metaBoard->location) }}" wire:navigate class="hover:text-[var(--ui-secondary)]">{{ $metaBoard->location->name }}</a>
                <span>/</span>
                <span class="text-[var(--ui-secondary)]">{{ $metaBoard->name }}</span>
            </nav>

            {{-- Header --}}
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-3">
                        <h1 class="text-2xl font-bold text-[var(--ui-secondary)]">{{ $metaBoard->name }}</h1>
                        <span class="px-2 py-1 text-xs font-medium text-purple-700 bg-purple-50 rounded">Meta Board</span>
                    </div>
                    @if($metaBoard->description)
                        <p class="text-[var(--ui-muted)] mt-1">{{ $metaBoard->description }}</p>
                    @endif
                </div>
                <div class="flex items-center gap-2">
                    <x-ui-button variant="primary" size="sm" wire:click="save">
                        <span class="inline-flex items-center gap-2">
                            @svg('heroicon-o-check', 'w-4 h-4')
                            <span>Speichern</span>
                        </span>
                    </x-ui-button>
                    <x-ui-button variant="secondary-outline" size="sm" :href="route('location.locations.show', $metaBoard->location)" wire:navigate>
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
                                class="w-full px-3 py-2 border border-[var(--ui-border)] rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[var(--ui-primary)]/20 focus:border-[var(--ui-primary)]" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[var(--ui-secondary)] mb-1">Hallennummer</label>
                            <input type="text" wire:model.blur="hallennummer" wire:change="updateField('hallennummer', $event.target.value)"
                                class="w-full px-3 py-2 border border-[var(--ui-border)] rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[var(--ui-primary)]/20 focus:border-[var(--ui-primary)]"
                                placeholder="z.B. Halle 1" />
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-[var(--ui-secondary)] mb-1">Adresse</label>
                        <input type="text" wire:model.blur="adresse" wire:change="updateField('adresse', $event.target.value)"
                            class="w-full px-3 py-2 border border-[var(--ui-border)] rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[var(--ui-primary)]/20 focus:border-[var(--ui-primary)]"
                            placeholder="Strasse, PLZ Ort" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-[var(--ui-secondary)] mb-1">Beschreibung</label>
                        <textarea wire:model.blur="description" wire:change="updateField('description', $event.target.value)"
                            rows="2"
                            class="w-full px-3 py-2 border border-[var(--ui-border)] rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[var(--ui-primary)]/20 focus:border-[var(--ui-primary)]"
                            placeholder="Optionale Beschreibung..."></textarea>
                    </div>
                </div>
            </x-ui-panel>

            {{-- Flaeche --}}
            <x-ui-panel title="Flaeche">
                <div class="p-4">
                    <div>
                        <label class="block text-sm font-medium text-[var(--ui-secondary)] mb-1">Flaeche (m²)</label>
                        <input type="number" step="0.01" wire:model.blur="flaeche_m2" wire:change="updateField('flaeche_m2', $event.target.value)"
                            class="w-full px-3 py-2 border border-[var(--ui-border)] rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[var(--ui-primary)]/20 focus:border-[var(--ui-primary)]"
                            placeholder="0.00" />
                    </div>
                </div>
            </x-ui-panel>

            {{-- Kapazitaet & Besonderheiten --}}
            <x-ui-panel title="Kapazitaet & Besonderheiten">
                <div class="p-4 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-[var(--ui-secondary)] mb-1">Personenauslastung (max.) inkl. Personal</label>
                            <input type="number" step="1" wire:model.blur="personenauslastung_max" wire:change="updateField('personenauslastung_max', $event.target.value)"
                                class="w-full px-3 py-2 border border-[var(--ui-border)] rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[var(--ui-primary)]/20 focus:border-[var(--ui-primary)]"
                                placeholder="0" />
                        </div>
                        <div class="flex items-center pt-6">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" wire:model.live="barrierefreiheit" wire:change="updateField('barrierefreiheit', $event.target.checked)"
                                    class="sr-only peer" />
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-[var(--ui-primary)]/20 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[var(--ui-primary)]"></div>
                                <span class="ms-3 text-sm font-medium text-[var(--ui-secondary)]">Barrierefreiheit vorhanden</span>
                            </label>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-[var(--ui-secondary)] mb-1">Besonderheit</label>
                        <textarea wire:model.blur="besonderheit" wire:change="updateField('besonderheit', $event.target.value)"
                            rows="3"
                            class="w-full px-3 py-2 border border-[var(--ui-border)] rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[var(--ui-primary)]/20 focus:border-[var(--ui-primary)]"
                            placeholder="Besonderheiten der Location..."></textarea>
                    </div>
                </div>
            </x-ui-panel>

            {{-- Anlaesse --}}
            <x-ui-panel title="Anlaesse" :subtitle="count($selectedOccasionIds) . ' ausgewaehlt'">
                <div class="p-4">
                    @if(count($occasions) > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                            @foreach($occasions as $occasion)
                                <label class="flex items-center gap-3 p-3 rounded-lg border cursor-pointer transition-all
                                    {{ in_array($occasion['id'], $selectedOccasionIds) ? 'border-purple-300 bg-purple-50' : 'border-[var(--ui-border)] hover:border-purple-200 hover:bg-purple-50/50' }}">
                                    <input type="checkbox"
                                        wire:click="toggleOccasion({{ $occasion['id'] }})"
                                        {{ in_array($occasion['id'], $selectedOccasionIds) ? 'checked' : '' }}
                                        class="w-4 h-4 rounded border-gray-300 text-purple-600 focus:ring-purple-500" />
                                    <div>
                                        <div class="text-sm font-medium text-[var(--ui-secondary)]">{{ $occasion['name'] }}</div>
                                        @if(!empty($occasion['description']))
                                            <div class="text-xs text-[var(--ui-muted)]">{{ $occasion['description'] }}</div>
                                        @endif
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center text-[var(--ui-muted)] py-4">
                            <p>Keine Anlaesse vorhanden.</p>
                            <a href="{{ route('location.settings.occasions.index') }}" wire:navigate class="text-sm text-[var(--ui-primary)] hover:underline mt-1 inline-block">
                                Anlaesse verwalten
                            </a>
                        </div>
                    @endif
                </div>
            </x-ui-panel>

            {{-- Bestuhlungen --}}
            <x-ui-panel title="Bestuhlungen" :subtitle="count($selectedSeatingIds) . ' ausgewaehlt'">
                <div class="p-4">
                    @if(count($seatings) > 0)
                        <div class="space-y-3">
                            @foreach($seatings as $seating)
                                <div class="flex items-center gap-4 p-3 rounded-lg border transition-all
                                    {{ in_array($seating['id'], $selectedSeatingIds) ? 'border-blue-300 bg-blue-50' : 'border-[var(--ui-border)] hover:border-blue-200 hover:bg-blue-50/50' }}">
                                    <label class="flex items-center gap-3 cursor-pointer flex-shrink-0">
                                        <input type="checkbox"
                                            wire:click="toggleSeating({{ $seating['id'] }})"
                                            {{ in_array($seating['id'], $selectedSeatingIds) ? 'checked' : '' }}
                                            class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" />
                                        <div>
                                            <div class="text-sm font-medium text-[var(--ui-secondary)]">{{ $seating['name'] }}</div>
                                            @if(!empty($seating['description']))
                                                <div class="text-xs text-[var(--ui-muted)]">{{ $seating['description'] }}</div>
                                            @endif
                                        </div>
                                    </label>
                                    @if(in_array($seating['id'], $selectedSeatingIds))
                                        <div class="flex items-center gap-2 ml-auto flex-shrink-0">
                                            <label class="text-xs text-[var(--ui-muted)] whitespace-nowrap">Max. PAX</label>
                                            <input type="number" step="1" min="0"
                                                wire:change="updateSeatingMaxPax({{ $seating['id'] }}, $event.target.value)"
                                                value="{{ $seatingMaxPax[$seating['id']] ?? '' }}"
                                                class="w-24 px-2 py-1 border border-[var(--ui-border)] rounded text-sm text-right focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500"
                                                placeholder="0" />
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center text-[var(--ui-muted)] py-4">
                            <p>Keine Bestuhlungen vorhanden.</p>
                            <a href="{{ route('location.settings.seatings.index') }}" wire:navigate class="text-sm text-[var(--ui-primary)] hover:underline mt-1 inline-block">
                                Bestuhlungen verwalten
                            </a>
                        </div>
                    @endif
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
                        <x-ui-button variant="secondary-outline" size="sm" :href="route('location.locations.show', $metaBoard->location)" wire:navigate class="w-full">
                            <span class="flex items-center gap-2">
                                @svg('heroicon-o-map-pin', 'w-4 h-4')
                                {{ $metaBoard->location->name }}
                            </span>
                        </x-ui-button>
                    </div>
                </div>

                {{-- Board Info --}}
                <div>
                    <h3 class="text-sm font-bold text-[var(--ui-secondary)] uppercase tracking-wider mb-3">Board Info</h3>
                    <div class="space-y-3">
                        <div class="p-3 bg-purple-50 rounded-lg border border-purple-100">
                            <div class="text-xs text-purple-600">Typ</div>
                            <div class="text-sm font-medium text-purple-700">Meta Board</div>
                        </div>
                        <div class="p-3 bg-[var(--ui-muted-5)] rounded-lg border border-[var(--ui-border)]/40">
                            <div class="text-xs text-[var(--ui-muted)]">Anlaesse</div>
                            <div class="text-sm font-medium text-[var(--ui-secondary)]">{{ count($selectedOccasionIds) }}</div>
                        </div>
                        <div class="p-3 bg-[var(--ui-muted-5)] rounded-lg border border-[var(--ui-border)]/40">
                            <div class="text-xs text-[var(--ui-muted)]">Bestuhlungen</div>
                            <div class="text-sm font-medium text-[var(--ui-secondary)]">{{ count($selectedSeatingIds) }}</div>
                        </div>
                        <div class="p-3 bg-[var(--ui-muted-5)] rounded-lg border border-[var(--ui-border)]/40">
                            <div class="text-xs text-[var(--ui-muted)]">Erstellt am</div>
                            <div class="text-sm font-medium text-[var(--ui-secondary)]">{{ $metaBoard->created_at->format('d.m.Y H:i') }}</div>
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
                        <div class="font-medium text-[var(--ui-secondary)] truncate">Meta Board geoeffnet</div>
                        <div class="text-[var(--ui-muted)]">vor 1 Minute</div>
                    </div>
                </div>
            </div>
        </x-ui-page-sidebar>
    </x-slot>
</x-ui-page>
