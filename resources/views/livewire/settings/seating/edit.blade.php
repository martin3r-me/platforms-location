<x-ui-page>
    <x-slot name="navbar">
        <x-ui-page-navbar title="Bestuhlung bearbeiten" icon="heroicon-o-square-3-stack-3d" />
    </x-slot>

    <x-ui-page-container>
        <div class="space-y-6">
            {{-- Header --}}
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-2 text-sm text-[var(--ui-muted)] mb-2">
                        <a href="{{ route('location.settings.seatings.index') }}" wire:navigate class="hover:text-[var(--ui-secondary)]">Bestuhlungen</a>
                        @svg('heroicon-o-chevron-right', 'w-3 h-3')
                        <span>{{ $seating->name }}</span>
                    </div>
                    <h1 class="text-2xl font-bold text-[var(--ui-secondary)]">Bestuhlung bearbeiten</h1>
                </div>
            </div>

            {{-- Form --}}
            <x-ui-panel title="Bestuhlungsdetails">
                <div class="space-y-6 p-2">
                    <x-ui-form-grid :cols="1" :gap="4">
                        <x-ui-input-text
                            name="name"
                            label="Name"
                            wire:model="name"
                            placeholder="z.B. Reihenbestuhlung..."
                            required
                            :errorKey="'name'"
                        />

                        <x-ui-input-textarea
                            name="description"
                            label="Beschreibung"
                            wire:model="description"
                            placeholder="Beschreibung eingeben..."
                            :errorKey="'description'"
                        />

                        <x-ui-input-checkbox
                            model="is_active"
                            name="is_active"
                            wire:model="is_active"
                            checked-label="Aktiv"
                            unchecked-label="Inaktiv"
                        />
                    </x-ui-form-grid>

                    <div class="flex items-center gap-3 pt-4 border-t border-[var(--ui-border)]">
                        <x-ui-button variant="success" wire:click="save">
                            <span class="inline-flex items-center gap-2">
                                @svg('heroicon-o-check', 'w-4 h-4')
                                <span>Speichern</span>
                            </span>
                        </x-ui-button>
                        <x-ui-button variant="secondary" :href="route('location.settings.seatings.index')" wire:navigate>
                            Abbrechen
                        </x-ui-button>
                    </div>
                </div>
            </x-ui-panel>
        </div>
    </x-ui-page-container>

    <x-slot name="sidebar">
        <x-ui-page-sidebar title="Quick Access" width="w-80" :defaultOpen="true">
            <div class="p-6 space-y-6">
                <div>
                    <h3 class="text-sm font-bold text-[var(--ui-secondary)] uppercase tracking-wider mb-3">Aktionen</h3>
                    <div class="space-y-2">
                        <x-ui-button variant="secondary-outline" size="sm" :href="route('location.settings.seatings.index')" wire:navigate class="w-full">
                            <span class="flex items-center gap-2">
                                @svg('heroicon-o-arrow-left', 'w-4 h-4')
                                Zurueck zu Bestuhlungen
                            </span>
                        </x-ui-button>
                    </div>
                </div>

                <div>
                    <h3 class="text-sm font-bold text-[var(--ui-secondary)] uppercase tracking-wider mb-3">Info</h3>
                    <div class="space-y-3">
                        <div class="p-3 bg-[var(--ui-muted-5)] rounded-lg border border-[var(--ui-border)]/40">
                            <div class="text-xs text-[var(--ui-muted)]">Erstellt</div>
                            <div class="text-sm font-medium text-[var(--ui-secondary)]">{{ $seating->created_at->format('d.m.Y H:i') }}</div>
                        </div>
                        <div class="p-3 bg-[var(--ui-muted-5)] rounded-lg border border-[var(--ui-border)]/40">
                            <div class="text-xs text-[var(--ui-muted)]">Zuletzt aktualisiert</div>
                            <div class="text-sm font-medium text-[var(--ui-secondary)]">{{ $seating->updated_at->format('d.m.Y H:i') }}</div>
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
