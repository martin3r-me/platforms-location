<?php

namespace Platform\Location\Livewire\Settings;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Platform\Location\Models\LocationOccasion;
use Livewire\Attributes\On;

class OccasionIndex extends Component
{
    #[On('occasionDeleted')]
    public function render()
    {
        $user = Auth::user();
        $team = $user->currentTeam;

        $occasions = LocationOccasion::query()
            ->where('team_id', $team->id)
            ->orderBy('order')
            ->get();

        return view('location::livewire.settings.occasion.index', [
            'occasions' => $occasions,
        ])->layout('platform::layouts.app');
    }

    public function delete($id)
    {
        $user = Auth::user();
        $team = $user->currentTeam;

        $occasion = LocationOccasion::query()
            ->where('team_id', $team->id)
            ->findOrFail($id);

        $occasion->delete();

        $this->dispatch('notifications:store', [
            'title' => 'Occasion deleted',
            'message' => 'The occasion has been deleted.',
            'notice_type' => 'success',
            'noticable_type' => LocationOccasion::class,
            'noticable_id' => $id,
        ]);

        $this->dispatch('occasionDeleted');
    }
}
