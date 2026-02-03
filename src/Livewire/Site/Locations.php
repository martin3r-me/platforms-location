<?php

namespace Platform\Location\Livewire\Site;

use Livewire\Component;
use Platform\Location\Models\LocationSite;

class Locations extends Component
{
    public LocationSite $site;

    public function mount(LocationSite $site)
    {
        $this->site = $site;
    }

    public function render()
    {
        $locations = $this->site->locations()->orderBy('name')->get();

        return view('location::livewire.site.locations', [
            'locations' => $locations,
        ])->layout('platform::layouts.app');
    }
}
