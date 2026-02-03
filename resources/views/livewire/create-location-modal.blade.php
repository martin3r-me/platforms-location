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
    </x-ui-form-grid>

    <x-slot name="footer">
        <x-ui-button variant="secondary" wire:click="closeModal">Abbrechen</x-ui-button>
        <x-ui-button variant="success" wire:click="save">Erstellen</x-ui-button>
    </x-slot>
</x-ui-modal>
