<?php

namespace Platform\Location\Livewire\ContentBoard;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Platform\Location\Models\LocationContentBoard;
use Platform\Location\Models\LocationContentBoardItem;

class Show extends Component
{
    public LocationContentBoard $contentBoard;
    public array $items = [];

    public function mount(LocationContentBoard $contentBoard)
    {
        $this->contentBoard = $contentBoard;
        $this->loadItems();
    }

    public function loadItems()
    {
        $this->items = $this->contentBoard->items()
            ->orderBy('order')
            ->get()
            ->toArray();
    }

    public function addItem()
    {
        LocationContentBoardItem::create([
            'content_board_id' => $this->contentBoard->id,
            'content' => '',
            'user_id' => Auth::id(),
            'team_id' => Auth::user()->currentTeam->id,
        ]);
        $this->loadItems();
    }

    public function updateItemContent($itemId, $content)
    {
        LocationContentBoardItem::find($itemId)?->update(['content' => $content]);
    }

    public function deleteItem($itemId)
    {
        LocationContentBoardItem::find($itemId)?->delete();
        $this->loadItems();
    }

    public function updateItemOrder($orderedIds)
    {
        foreach ($orderedIds as $index => $item) {
            $id = is_array($item) ? $item['value'] : $item;
            LocationContentBoardItem::where('id', $id)->update(['order' => $index]);
        }
        $this->loadItems();
    }

    public function render()
    {
        return view('location::livewire.content-board.show')
            ->layout('platform::layouts.app');
    }
}
