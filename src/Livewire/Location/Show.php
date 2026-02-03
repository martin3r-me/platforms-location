<?php

namespace Platform\Location\Livewire\Location;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Platform\Location\Models\LocationLocation;
use Platform\Location\Models\LocationContentBoard;
use Platform\Location\Models\LocationGalleryBoard;

class Show extends Component
{
    public LocationLocation $location;

    public function mount(LocationLocation $location)
    {
        $this->location = $location;
    }

    public function createContentBoard()
    {
        $user = Auth::user();
        $team = $user->currentTeam;

        $board = LocationContentBoard::create([
            'location_id' => $this->location->id,
            'name' => 'Neues Content Board',
            'user_id' => $user->id,
            'team_id' => $team->id,
        ]);

        return redirect()->route('location.content-boards.show', $board);
    }

    public function createGalleryBoard()
    {
        $user = Auth::user();
        $team = $user->currentTeam;

        $board = LocationGalleryBoard::create([
            'location_id' => $this->location->id,
            'name' => 'Neues Gallery Board',
            'user_id' => $user->id,
            'team_id' => $team->id,
        ]);

        return redirect()->route('location.gallery-boards.show', $board);
    }

    public function render()
    {
        $contentBoards = $this->location->contentBoards()->get();
        $galleryBoards = $this->location->galleryBoards()->get();

        return view('location::livewire.location.show', [
            'contentBoards' => $contentBoards,
            'galleryBoards' => $galleryBoards,
        ])->layout('platform::layouts.app');
    }
}
