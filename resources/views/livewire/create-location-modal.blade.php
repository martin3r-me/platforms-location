<x-ui-modal size="md" model="modalShow" header="Neue Location erstellen">
    <x-ui-form-grid :cols="1" :gap="4">
        <x-ui-input-text
            name="name"
            label="Name"
            wire:model="name"
            placeholder="Location Name eingeben..."
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

        @if($preselectedSite)
            <div>
                <label class="block text-sm font-medium text-[var(--ui-secondary)] mb-1">Site</label>
                <div class="p-3 rounded-md border border-[var(--ui-border)] bg-[var(--ui-muted-5)]">
                    <div class="flex items-center gap-2">
                        @svg('heroicon-o-globe-alt', 'w-4 h-4 text-[var(--ui-secondary)]')
                        <span class="font-medium text-[var(--ui-secondary)]">{{ $preselectedSite->name }}</span>
                        @if($preselectedSite->is_international)
                            <span class="px-2 py-0.5 text-xs font-medium text-blue-700 bg-blue-100 rounded">International</span>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <x-ui-input-select
                name="site_id"
                label="Site"
                wire:model="site_id"
                :options="$sites->map(fn($s) => ['value' => $s->id, 'label' => $s->name])->values()"
                required
                :errorKey="'site_id'"
            />
        @endif
    </x-ui-form-grid>

    <x-slot name="footer">
        <x-ui-button variant="secondary" wire:click="closeModal">Abbrechen</x-ui-button>
        <x-ui-button variant="success" wire:click="save">Erstellen</x-ui-button>
    </x-slot>
</x-ui-modal>
