<?php

namespace Platform\Location\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Platform\Location\Models\LocationLocation;
use Livewire\Attributes\On;

class CreateLocationModal extends Component
{
    public $modalShow = false;
    public $name = '';
    public $description = '';

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ];
    }

    #[On('open-modal-create-location')]
    public function openModal()
    {
        $this->reset(['name', 'description']);
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
            'created_by_user_id' => $user->id,
            'owned_by_user_id' => $user->id,
            'team_id' => $team->id,
            'is_active' => true,
        ]);

        $this->dispatch('notifications:store', [
            'title' => 'Location erstellt',
            'message' => 'Die Location wurde erfolgreich angelegt.',
            'notice_type' => 'success',
            'noticable_type' => LocationLocation::class,
            'noticable_id' => $location->id,
        ]);

        $this->reset(['name', 'description']);
        $this->closeModal();
        $this->dispatch('locationCreated');
        $this->redirect(route('location.locations.index'), navigate: true);
    }

    public function closeModal()
    {
        $this->modalShow = false;
    }

    public function render()
    {
        return view('location::livewire.create-location-modal')->layout('platform::layouts.app');
    }
}
