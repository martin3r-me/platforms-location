<?php

namespace Platform\Location\Livewire\MetaBoard;

use Livewire\Component;
use Platform\Location\Models\LocationMetaBoard;
use Platform\Location\Models\LocationOccasion;

class Show extends Component
{
    public LocationMetaBoard $metaBoard;

    // Editable fields
    public ?string $name = '';
    public ?string $description = '';
    public $flaeche_m2 = null;
    public $mietpreis_aufbautag = null;
    public $mietpreis_abbautag = null;
    public $mietpreis_va_tag = null;
    public ?string $adresse = '';
    public ?string $hallennummer = '';
    public $personenauslastung_max = null;
    public ?string $besonderheit = '';
    public bool $barrierefreiheit = false;

    public array $occasions = [];
    public array $selectedOccasionIds = [];

    public function mount(LocationMetaBoard $metaBoard)
    {
        $this->metaBoard = $metaBoard;
        $this->fillFromModel();
        $this->loadOccasions();
    }

    protected function fillFromModel(): void
    {
        $this->name = $this->metaBoard->name;
        $this->description = $this->metaBoard->description ?? '';
        $this->flaeche_m2 = $this->metaBoard->flaeche_m2;
        $this->mietpreis_aufbautag = $this->metaBoard->mietpreis_aufbautag;
        $this->mietpreis_abbautag = $this->metaBoard->mietpreis_abbautag;
        $this->mietpreis_va_tag = $this->metaBoard->mietpreis_va_tag;
        $this->adresse = $this->metaBoard->adresse ?? '';
        $this->hallennummer = $this->metaBoard->hallennummer ?? '';
        $this->personenauslastung_max = $this->metaBoard->personenauslastung_max;
        $this->besonderheit = $this->metaBoard->besonderheit ?? '';
        $this->barrierefreiheit = $this->metaBoard->barrierefreiheit ?? false;
        $this->selectedOccasionIds = $this->metaBoard->occasions()->pluck('location_occasions.id')->toArray();
    }

    public function loadOccasions(): void
    {
        $this->occasions = LocationOccasion::forTeam($this->metaBoard->team_id)
            ->active()
            ->orderBy('order')
            ->get()
            ->toArray();
    }

    public function toggleOccasion($occasionId): void
    {
        $occasionId = (int) $occasionId;

        if (in_array($occasionId, $this->selectedOccasionIds)) {
            $this->selectedOccasionIds = array_values(
                array_filter($this->selectedOccasionIds, fn ($id) => $id !== $occasionId)
            );
            $this->metaBoard->occasions()->detach($occasionId);
        } else {
            $this->selectedOccasionIds[] = $occasionId;
            $this->metaBoard->occasions()->attach($occasionId);
        }
    }

    public function updateField($field, $value): void
    {
        $allowed = [
            'name', 'description', 'flaeche_m2', 'mietpreis_aufbautag',
            'mietpreis_abbautag', 'mietpreis_va_tag', 'adresse', 'hallennummer',
            'personenauslastung_max', 'besonderheit', 'barrierefreiheit',
        ];

        if (!in_array($field, $allowed)) {
            return;
        }

        // Convert empty strings to null for nullable numeric fields
        $numericFields = ['flaeche_m2', 'mietpreis_aufbautag', 'mietpreis_abbautag', 'mietpreis_va_tag', 'personenauslastung_max'];
        if (in_array($field, $numericFields) && ($value === '' || $value === null)) {
            $value = null;
        }

        $this->metaBoard->update([$field => $value]);
        $this->{$field} = $value;
    }

    public function save(): void
    {
        $this->metaBoard->update([
            'name' => $this->name,
            'description' => $this->description ?: null,
            'flaeche_m2' => $this->flaeche_m2 ?: null,
            'mietpreis_aufbautag' => $this->mietpreis_aufbautag ?: null,
            'mietpreis_abbautag' => $this->mietpreis_abbautag ?: null,
            'mietpreis_va_tag' => $this->mietpreis_va_tag ?: null,
            'adresse' => $this->adresse ?: null,
            'hallennummer' => $this->hallennummer ?: null,
            'personenauslastung_max' => $this->personenauslastung_max ?: null,
            'besonderheit' => $this->besonderheit ?: null,
            'barrierefreiheit' => $this->barrierefreiheit,
        ]);

        $this->metaBoard->occasions()->sync($this->selectedOccasionIds);

        session()->flash('success', 'Meta Board gespeichert.');
    }

    public function render()
    {
        return view('location::livewire.meta-board.show')
            ->layout('platform::layouts.app');
    }
}
