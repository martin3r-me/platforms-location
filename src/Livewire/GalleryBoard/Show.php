<?php

namespace Platform\Location\Livewire\GalleryBoard;

use Livewire\Component;
use Platform\Location\Models\LocationGalleryBoard;

class Show extends Component
{
    public LocationGalleryBoard $galleryBoard;

    public function mount(LocationGalleryBoard $galleryBoard)
    {
        $this->galleryBoard = $galleryBoard;
    }

    public function render()
    {
        return view('location::livewire.gallery-board.show')
            ->layout('platform::layouts.app');
    }
}
