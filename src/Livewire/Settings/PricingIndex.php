<?php

namespace Platform\Location\Livewire\Settings;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Platform\Location\Models\LocationPricing;
use Livewire\Attributes\On;

class PricingIndex extends Component
{
    #[On('pricingDeleted')]
    public function render()
    {
        $user = Auth::user();
        $team = $user->currentTeam;

        $pricings = LocationPricing::query()
            ->where('team_id', $team->id)
            ->with('location.site')
            ->orderBy('location_id')
            ->orderBy('order')
            ->get()
            ->groupBy(fn ($pricing) => $pricing->location->name);

        return view('location::livewire.settings.pricing.index', [
            'pricingGroups' => $pricings,
            'totalCount' => $pricings->flatten()->count(),
        ])->layout('platform::layouts.app');
    }

    public function delete($id)
    {
        $user = Auth::user();
        $team = $user->currentTeam;

        $pricing = LocationPricing::query()
            ->where('team_id', $team->id)
            ->findOrFail($id);

        $pricing->delete();

        $this->dispatch('notifications:store', [
            'title' => 'Pricing Board geloescht',
            'message' => 'Das Pricing Board wurde geloescht.',
            'notice_type' => 'success',
            'noticable_type' => LocationPricing::class,
            'noticable_id' => $id,
        ]);

        $this->dispatch('pricingDeleted');
    }
}
