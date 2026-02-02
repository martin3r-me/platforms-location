<?php

namespace Platform\Location\Livewire\Standort;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Platform\Location\Models\LocationStandort;

class Index extends Component
{
    public function render()
    {
        $user = Auth::user();
        $team = $user->currentTeam;
        
        $standorte = LocationStandort::query()
            ->where('team_id', $team->id)
            ->with('location')
            ->orderBy('name')
            ->get();
        
        return view('location::livewire.standort.index', [
            'standorte' => $standorte,
        ])->layout('platform::layouts.app');
    }
}
