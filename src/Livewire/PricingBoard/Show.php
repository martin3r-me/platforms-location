<?php

namespace Platform\Location\Livewire\PricingBoard;

use Livewire\Component;
use Platform\Location\Models\LocationPricing;

class Show extends Component
{
    public LocationPricing $pricingBoard;

    // Editable fields
    public ?string $name = '';
    public ?string $description = '';
    public $mietpreis_aufbautag = null;
    public $mietpreis_abbautag = null;
    public $mietpreis_va_tag = null;
    public $energiekosten_pro_tag = null;
    public ?string $preisanmerkungen = '';
    public ?string $valid_from = '';
    public ?string $valid_to = '';

    public function mount(LocationPricing $pricingBoard)
    {
        $this->pricingBoard = $pricingBoard;
        $this->fillFromModel();
    }

    protected function fillFromModel(): void
    {
        $this->name = $this->pricingBoard->name;
        $this->description = $this->pricingBoard->description ?? '';
        $this->mietpreis_aufbautag = $this->pricingBoard->mietpreis_aufbautag;
        $this->mietpreis_abbautag = $this->pricingBoard->mietpreis_abbautag;
        $this->mietpreis_va_tag = $this->pricingBoard->mietpreis_va_tag;
        $this->energiekosten_pro_tag = $this->pricingBoard->energiekosten_pro_tag;
        $this->preisanmerkungen = $this->pricingBoard->preisanmerkungen ?? '';
        $this->valid_from = $this->pricingBoard->valid_from?->format('Y-m-d') ?? '';
        $this->valid_to = $this->pricingBoard->valid_to?->format('Y-m-d') ?? '';
    }

    public function updateField($field, $value): void
    {
        $allowed = [
            'name', 'description', 'mietpreis_aufbautag',
            'mietpreis_abbautag', 'mietpreis_va_tag', 'energiekosten_pro_tag',
            'preisanmerkungen', 'valid_from', 'valid_to',
        ];

        if (!in_array($field, $allowed)) {
            return;
        }

        // Convert empty strings to null for nullable fields
        $numericFields = ['mietpreis_aufbautag', 'mietpreis_abbautag', 'mietpreis_va_tag', 'energiekosten_pro_tag'];
        if (in_array($field, $numericFields) && ($value === '' || $value === null)) {
            $value = null;
        }

        $dateFields = ['valid_from', 'valid_to'];
        if (in_array($field, $dateFields) && ($value === '' || $value === null)) {
            $value = null;
        }

        $this->pricingBoard->update([$field => $value]);
        $this->{$field} = $value;
    }

    public function save(): void
    {
        $this->pricingBoard->update([
            'name' => $this->name,
            'description' => $this->description ?: null,
            'mietpreis_aufbautag' => $this->mietpreis_aufbautag ?: null,
            'mietpreis_abbautag' => $this->mietpreis_abbautag ?: null,
            'mietpreis_va_tag' => $this->mietpreis_va_tag ?: null,
            'energiekosten_pro_tag' => $this->energiekosten_pro_tag ?: null,
            'preisanmerkungen' => $this->preisanmerkungen ?: null,
            'valid_from' => $this->valid_from ?: null,
            'valid_to' => $this->valid_to ?: null,
        ]);

        session()->flash('success', 'Pricing Board gespeichert.');
    }

    public function toggleDone(): void
    {
        $this->pricingBoard->update([
            'done' => !$this->pricingBoard->done,
            'done_at' => !$this->pricingBoard->done ? now() : null,
        ]);

        $this->pricingBoard->refresh();
    }

    public function render()
    {
        return view('location::livewire.pricing-board.show')
            ->layout('platform::layouts.app');
    }
}
