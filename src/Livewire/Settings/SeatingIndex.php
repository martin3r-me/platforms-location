<?php

namespace Platform\Location\Livewire\Settings;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Platform\Location\Models\LocationSeating;
use Livewire\Attributes\On;

class SeatingIndex extends Component
{
    #[On('seatingDeleted')]
    public function render()
    {
        $user = Auth::user();
        $team = $user->currentTeam;

        $seatings = LocationSeating::query()
            ->where('team_id', $team->id)
            ->orderBy('order')
            ->get();

        return view('location::livewire.settings.seating.index', [
            'seatings' => $seatings,
        ])->layout('platform::layouts.app');
    }

    public function delete($id)
    {
        $user = Auth::user();
        $team = $user->currentTeam;

        $seating = LocationSeating::query()
            ->where('team_id', $team->id)
            ->findOrFail($id);

        $seating->delete();

        $this->dispatch('notifications:store', [
            'title' => 'Bestuhlung geloescht',
            'message' => 'Die Bestuhlung wurde geloescht.',
            'notice_type' => 'success',
            'noticable_type' => LocationSeating::class,
            'noticable_id' => $id,
        ]);

        $this->dispatch('seatingDeleted');
    }
}
