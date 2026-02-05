<?php

namespace Platform\Location\Livewire\MetaBoard;

use Livewire\Component;
use Platform\Location\Models\LocationMetaBoard;
use Platform\Location\Models\LocationOccasion;
use Platform\Location\Models\LocationSeating;

class Show extends Component
{
    public LocationMetaBoard $metaBoard;

    // Editable fields
    public ?string $name = '';
    public ?string $description = '';
    public $flaeche_m2 = null;
    public ?string $adresse = '';
    public ?string $hallennummer = '';
    public $personenauslastung_max = null;
    public ?string $besonderheit = '';
    public bool $barrierefreiheit = false;

    public array $occasions = [];
    public array $selectedOccasionIds = [];

    public array $seatings = [];
    public array $selectedSeatingIds = [];
    public array $seatingMaxPax = [];

    public function mount(LocationMetaBoard $metaBoard)
    {
        $this->metaBoard = $metaBoard;
        $this->fillFromModel();
        $this->loadOccasions();
        $this->loadSeatings();
    }

    protected function fillFromModel(): void
    {
        $this->name = $this->metaBoard->name;
        $this->description = $this->metaBoard->description ?? '';
        $this->flaeche_m2 = $this->metaBoard->flaeche_m2;
        $this->adresse = $this->metaBoard->adresse ?? '';
        $this->hallennummer = $this->metaBoard->hallennummer ?? '';
        $this->personenauslastung_max = $this->metaBoard->personenauslastung_max;
        $this->besonderheit = $this->metaBoard->besonderheit ?? '';
        $this->barrierefreiheit = $this->metaBoard->barrierefreiheit ?? false;
        $this->selectedOccasionIds = $this->metaBoard->occasions()->pluck('location_occasions.id')->toArray();

        $this->selectedSeatingIds = $this->metaBoard->seatings()->pluck('location_seatings.id')->toArray();
        $this->seatingMaxPax = [];
        foreach ($this->metaBoard->seatings as $seating) {
            $this->seatingMaxPax[$seating->id] = $seating->pivot->max_pax;
        }
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

    public function loadSeatings(): void
    {
        $this->seatings = LocationSeating::forTeam($this->metaBoard->team_id)
            ->active()
            ->orderBy('order')
            ->get()
            ->toArray();
    }

    public function toggleSeating($seatingId): void
    {
        $seatingId = (int) $seatingId;

        if (in_array($seatingId, $this->selectedSeatingIds)) {
            $this->selectedSeatingIds = array_values(
                array_filter($this->selectedSeatingIds, fn ($id) => $id !== $seatingId)
            );
            unset($this->seatingMaxPax[$seatingId]);
            $this->metaBoard->seatings()->detach($seatingId);
        } else {
            $this->selectedSeatingIds[] = $seatingId;
            $this->seatingMaxPax[$seatingId] = null;
            $this->metaBoard->seatings()->attach($seatingId, ['max_pax' => null]);
        }
    }

    public function updateSeatingMaxPax($seatingId, $value): void
    {
        $seatingId = (int) $seatingId;
        $maxPax = ($value === '' || $value === null) ? null : (int) $value;

        $this->seatingMaxPax[$seatingId] = $maxPax;
        $this->metaBoard->seatings()->updateExistingPivot($seatingId, ['max_pax' => $maxPax]);
    }

    public function updateField($field, $value): void
    {
        $allowed = [
            'name', 'description', 'flaeche_m2', 'adresse', 'hallennummer',
            'personenauslastung_max', 'besonderheit', 'barrierefreiheit',
        ];

        if (!in_array($field, $allowed)) {
            return;
        }

        // Convert empty strings to null for nullable numeric fields
        $numericFields = ['flaeche_m2', 'personenauslastung_max'];
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
            'adresse' => $this->adresse ?: null,
            'hallennummer' => $this->hallennummer ?: null,
            'personenauslastung_max' => $this->personenauslastung_max ?: null,
            'besonderheit' => $this->besonderheit ?: null,
            'barrierefreiheit' => $this->barrierefreiheit,
        ]);

        $this->metaBoard->occasions()->sync($this->selectedOccasionIds);

        // Sync seatings with max_pax pivot data
        $seatingSync = [];
        foreach ($this->selectedSeatingIds as $seatingId) {
            $seatingSync[$seatingId] = ['max_pax' => $this->seatingMaxPax[$seatingId] ?? null];
        }
        $this->metaBoard->seatings()->sync($seatingSync);

        session()->flash('success', 'Meta Board gespeichert.');
    }

    public function render()
    {
        return view('location::livewire.meta-board.show')
            ->layout('platform::layouts.app');
    }
}
