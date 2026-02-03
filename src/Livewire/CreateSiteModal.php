<?php

namespace Platform\Location\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Platform\Location\Models\LocationSite;
use Livewire\Attributes\On;

class CreateSiteModal extends Component
{
    public $modalShow = false;
    public $name = '';
    public $description = '';

    // Address
    public $street = '';
    public $street_number = '';
    public $postal_code = '';
    public $city = '';
    public $state = '';
    public $country = '';
    public $country_code = '';

    // GPS
    public $latitude = null;
    public $longitude = null;

    // International
    public $is_international = false;
    public $timezone = '';

    // Contact
    public $phone = '';
    public $email = '';
    public $website = '';
    public $notes = '';

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'street' => 'nullable|string|max:255',
            'street_number' => 'nullable|string|max:50',
            'postal_code' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'country_code' => 'nullable|string|size:2',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'is_international' => 'boolean',
            'timezone' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'notes' => 'nullable|string',
        ];
    }

    #[On('open-modal-create-site')]
    public function openModal()
    {
        $this->reset([
            'name', 'description',
            'street', 'street_number', 'postal_code', 'city', 'state', 'country', 'country_code',
            'latitude', 'longitude',
            'is_international', 'timezone',
            'phone', 'email', 'website', 'notes',
        ]);
        $this->modalShow = true;
    }

    public function mount()
    {
        $this->modalShow = false;
    }

    public function save()
    {
        $this->validate();

        $user = Auth::user();
        $team = $user->currentTeam;

        $site = LocationSite::create([
            'name' => $this->name,
            'description' => $this->description,
            'street' => $this->street ?: null,
            'street_number' => $this->street_number ?: null,
            'postal_code' => $this->postal_code ?: null,
            'city' => $this->city ?: null,
            'state' => $this->state ?: null,
            'country' => $this->country ?: null,
            'country_code' => $this->country_code ?: null,
            'latitude' => $this->latitude ?: null,
            'longitude' => $this->longitude ?: null,
            'is_international' => $this->is_international,
            'timezone' => $this->timezone ?: null,
            'phone' => $this->phone ?: null,
            'email' => $this->email ?: null,
            'website' => $this->website ?: null,
            'notes' => $this->notes ?: null,
            'user_id' => $user->id,
            'team_id' => $team->id,
        ]);

        $this->dispatch('notifications:store', [
            'title' => 'Site erstellt',
            'message' => 'Die Site wurde erfolgreich angelegt.',
            'notice_type' => 'success',
            'noticable_type' => LocationSite::class,
            'noticable_id' => $site->id,
        ]);

        $this->reset([
            'name', 'description',
            'street', 'street_number', 'postal_code', 'city', 'state', 'country', 'country_code',
            'latitude', 'longitude',
            'is_international', 'timezone',
            'phone', 'email', 'website', 'notes',
        ]);
        $this->closeModal();
        $this->dispatch('siteCreated');
        $this->redirect(route('location.sites.index'), navigate: true);
    }

    public function closeModal()
    {
        $this->modalShow = false;
    }

    public function render()
    {
        return view('location::livewire.create-site-modal')->layout('platform::layouts.app');
    }
}
