<x-ui-modal size="lg" model="modalShow" header="Neue Site erstellen">
    <div class="space-y-6">
        {{-- Basis-Informationen --}}
        <div>
            <h3 class="text-sm font-semibold text-[var(--ui-secondary)] mb-4">Basis-Informationen</h3>
            <x-ui-form-grid :cols="1" :gap="4">
                <x-ui-input-text
                    name="name"
                    label="Name"
                    wire:model="name"
                    placeholder="Site Name eingeben..."
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
        </div>

        {{-- Adresse --}}
        <div>
            <h3 class="text-sm font-semibold text-[var(--ui-secondary)] mb-4">Adresse</h3>
            <x-ui-form-grid :cols="2" :gap="4">
                <x-ui-input-text
                    name="street"
                    label="Straße"
                    wire:model="street"
                    placeholder="Straßenname"
                    :errorKey="'street'"
                />

                <x-ui-input-text
                    name="street_number"
                    label="Hausnummer"
                    wire:model="street_number"
                    placeholder="Nr."
                    :errorKey="'street_number'"
                />

                <x-ui-input-text
                    name="postal_code"
                    label="PLZ"
                    wire:model="postal_code"
                    placeholder="Postleitzahl"
                    :errorKey="'postal_code'"
                />

                <x-ui-input-text
                    name="city"
                    label="Stadt"
                    wire:model="city"
                    placeholder="Stadt"
                    :errorKey="'city'"
                />

                <x-ui-input-text
                    name="state"
                    label="Bundesland/Region"
                    wire:model="state"
                    placeholder="Bundesland oder Region"
                    :errorKey="'state'"
                />

                <x-ui-input-text
                    name="country"
                    label="Land"
                    wire:model="country"
                    placeholder="Land"
                    :errorKey="'country'"
                />

                <x-ui-input-text
                    name="country_code"
                    label="Ländercode (ISO 3166-1 alpha-2)"
                    wire:model="country_code"
                    placeholder="z.B. DE, US, FR"
                    maxlength="2"
                    :errorKey="'country_code'"
                />
            </x-ui-form-grid>
        </div>

        {{-- GPS-Koordinaten --}}
        <div>
            <h3 class="text-sm font-semibold text-[var(--ui-secondary)] mb-4">GPS-Koordinaten</h3>
            <x-ui-form-grid :cols="2" :gap="4">
                <x-ui-input-text
                    name="latitude"
                    label="Breitengrad"
                    type="number"
                    step="0.000001"
                    wire:model="latitude"
                    placeholder="z.B. 52.520008"
                    :errorKey="'latitude'"
                />

                <x-ui-input-text
                    name="longitude"
                    label="Längengrad"
                    type="number"
                    step="0.000001"
                    wire:model="longitude"
                    placeholder="z.B. 13.404954"
                    :errorKey="'longitude'"
                />
            </x-ui-form-grid>
        </div>

        {{-- International --}}
        <div>
            <h3 class="text-sm font-semibold text-[var(--ui-secondary)] mb-4">International</h3>
            <x-ui-form-grid :cols="1" :gap="4">
                <x-ui-input-checkbox
                    model="is_international"
                    name="is_international"
                    wire:model="is_international"
                    checked-label="Internationale Site"
                    unchecked-label="Nationale Site"
                />

                <x-ui-input-text
                    name="timezone"
                    label="Zeitzone"
                    wire:model="timezone"
                    placeholder="z.B. Europe/Berlin, America/New_York"
                    :errorKey="'timezone'"
                />
            </x-ui-form-grid>
        </div>

        {{-- Kontaktinformationen --}}
        <div>
            <h3 class="text-sm font-semibold text-[var(--ui-secondary)] mb-4">Kontaktinformationen</h3>
            <x-ui-form-grid :cols="1" :gap="4">
                <x-ui-input-text
                    name="phone"
                    label="Telefon"
                    wire:model="phone"
                    placeholder="Telefonnummer"
                    :errorKey="'phone'"
                />

                <x-ui-input-text
                    name="email"
                    label="E-Mail"
                    type="email"
                    wire:model="email"
                    placeholder="E-Mail-Adresse"
                    :errorKey="'email'"
                />

                <x-ui-input-text
                    name="website"
                    label="Website"
                    type="url"
                    wire:model="website"
                    placeholder="https://..."
                    :errorKey="'website'"
                />
            </x-ui-form-grid>
        </div>

        {{-- Notizen --}}
        <div>
            <h3 class="text-sm font-semibold text-[var(--ui-secondary)] mb-4">Notizen</h3>
            <x-ui-form-grid :cols="1" :gap="4">
                <x-ui-input-textarea
                    name="notes"
                    label="Notizen"
                    wire:model="notes"
                    placeholder="Zusätzliche Notizen..."
                    :errorKey="'notes'"
                />
            </x-ui-form-grid>
        </div>
    </div>

    <x-slot name="footer">
        <x-ui-button variant="secondary" wire:click="closeModal">Abbrechen</x-ui-button>
        <x-ui-button variant="success" wire:click="save">Erstellen</x-ui-button>
    </x-slot>
</x-ui-modal>
