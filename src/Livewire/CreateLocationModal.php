<?php

namespace Platform\Location\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Platform\Location\Models\LocationLocation;
use Platform\Location\Models\LocationSite;
use Livewire\Attributes\On;

class CreateLocationModal extends Component
{
    public $modalShow = false;
    public $name = '';
    public $description = '';
    public $site_id = null;

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'site_id' => 'required|exists:location_sites,id',
        ];
    }

    #[On('open-modal-create-location')]
    public function openModal($siteId = null)
    {
        $this->reset(['name', 'description', 'site_id']);

        if ($siteId) {
            $this->site_id = $siteId;
        }

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

        $location = LocationLocation::create([
            'name' => $this->name,
            'description' => $this->description,
            'site_id' => $this->site_id,
            'user_id' => $user->id,
            'team_id' => $team->id,
        ]);

        $this->dispatch('notifications:store', [
            'title' => 'Location erstellt',
            'message' => 'Die Location wurde erfolgreich angelegt.',
            'notice_type' => 'success',
            'noticable_type' => LocationLocation::class,
            'noticable_id' => $location->id,
        ]);

        $this->reset(['name', 'description', 'site_id']);
        $this->closeModal();
        $this->dispatch('locationCreated');
        $this->redirect(route('location.locations.index'), navigate: true);
    }

    public function closeModal()
    {
        $this->modalShow = false;
    }

    public function getSitesProperty()
    {
        $user = Auth::user();
        $team = $user->currentTeam;

        return LocationSite::where('team_id', $team->id)
            ->orderBy('name')
            ->get();
    }

    public function render()
    {
        return view('location::livewire.create-location-modal', [
            'sites' => $this->sites,
        ])->layout('platform::layouts.app');
    }
}
