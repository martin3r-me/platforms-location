<?php

namespace Platform\Location\Livewire\GalleryBoard;

use Livewire\Attributes\On;
use Livewire\Component;
use Platform\Location\Models\LocationGalleryBoard;

class Show extends Component
{
    public LocationGalleryBoard $galleryBoard;
    public array $items = [];

    public function mount(LocationGalleryBoard $galleryBoard)
    {
        $this->galleryBoard = $galleryBoard;
        $this->loadItems();
    }

    public function rendered(): void
    {
        // Kontext setzen für ModalFiles
        $this->dispatch('files', [
            'context_type' => get_class($this->galleryBoard),
            'context_id' => $this->galleryBoard->id,
        ]);
    }

    public function loadItems(): void
    {
        // Nutzt HasContextFileReferences Trait
        $this->items = $this->galleryBoard->getFileReferencesArray();
    }

    public function openFilePicker(): void
    {
        $this->dispatch('files:picker', [
            'callback' => 'addSelectedFiles',
            'multiple' => true,
        ]);
    }

    #[On('files:selected')]
    public function handleFilesSelected(array $payload): void
    {
        if (($payload['callback'] ?? null) !== 'addSelectedFiles') {
            return;
        }

        foreach ($payload['files'] as $file) {
            $this->galleryBoard->addFileReference($file['id'], [
                'title' => $file['original_name'],
            ]);
        }

        $this->loadItems();
        $this->dispatch('notify', ['type' => 'success', 'message' => count($payload['files']) . ' Bild(er) hinzugefügt']);
    }

    public function updateItemOrder(array $orderedIds): void
    {
        $ids = array_map(fn($id) => is_array($id) ? $id['value'] : $id, $orderedIds);
        $this->galleryBoard->updateFileReferenceOrder($ids);
        $this->loadItems();
    }

    public function deleteItem(int $referenceId): void
    {
        // Nur die Referenz löschen, nicht das File selbst!
        $this->galleryBoard->removeFileReference($referenceId);
        $this->loadItems();
        $this->dispatch('notify', ['type' => 'success', 'message' => 'Bild entfernt']);
    }

    public function render()
    {
        return view('location::livewire.gallery-board.show')
            ->layout('platform::layouts.app');
    }
}
