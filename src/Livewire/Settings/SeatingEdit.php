<?php

namespace Platform\Location\Livewire\Settings;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Platform\Location\Models\LocationSeating;

class SeatingEdit extends Component
{
    public LocationSeating $seating;

    public $name = '';
    public $description = '';
    public $is_active = true;

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ];
    }

    public function mount(LocationSeating $seating)
    {
        $user = Auth::user();
        $team = $user->currentTeam;

        abort_unless($seating->team_id === $team->id, 403);

        $this->seating = $seating;
        $this->name = $seating->name;
        $this->description = $seating->description ?? '';
        $this->is_active = $seating->is_active;
    }

    public function save()
    {
        $this->validate();

        $this->seating->update([
            'name' => $this->name,
            'description' => $this->description ?: null,
            'is_active' => $this->is_active,
        ]);

        $this->dispatch('notifications:store', [
            'title' => 'Bestuhlung aktualisiert',
            'message' => 'Die Bestuhlung wurde aktualisiert.',
            'notice_type' => 'success',
            'noticable_type' => LocationSeating::class,
            'noticable_id' => $this->seating->id,
        ]);

        $this->redirect(route('location.settings.seatings.index'), navigate: true);
    }

    public function render()
    {
        return view('location::livewire.settings.seating.edit')
            ->layout('platform::layouts.app');
    }
}
