<?php

namespace Platform\Location\Livewire\Site;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Platform\Location\Models\LocationSite;

class Index extends Component
{
    public function render()
    {
        $user = Auth::user();
        $team = $user->currentTeam;

        $sites = LocationSite::query()
            ->where('team_id', $team->id)
            ->withCount('locations')
            ->orderBy('name')
            ->get();

        $internationalCount = $sites->where('is_international', true)->count();

        return view('location::livewire.site.index', [
            'sites' => $sites,
            'internationalCount' => $internationalCount,
        ])->layout('platform::layouts.app');
    }
}
