<?php

namespace Platform\Location\Livewire\Location;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Platform\Location\Models\LocationLocation;

class Index extends Component
{
    public function render()
    {
        $user = Auth::user();
        $team = $user->currentTeam;
        
        $locations = LocationLocation::query()
            ->where('team_id', $team->id)
            ->orderBy('name')
            ->get();
        
        return view('location::livewire.location.index', [
            'locations' => $locations,
        ])->layout('platform::layouts.app');
    }
}
