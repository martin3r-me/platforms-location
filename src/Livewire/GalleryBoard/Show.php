<?php

namespace Platform\Location\Livewire\GalleryBoard;

use Livewire\Attributes\On;
use Livewire\Component;
use Platform\Core\Models\ContextFileReference;
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
        // Files-Tab im Terminal aktivieren
        $this->dispatch('terminal:app:files');

        // Kontext für Terminal setzen
        $this->dispatch('comms', [
            'model' => $this->galleryBoard->getFileContextType(),
            'modelId' => $this->galleryBoard->getFileContextId(),
            'subject' => $this->galleryBoard->name ?? 'Gallery Board',
            'source' => 'location',
        ]);
    }

    public function loadItems(): void
    {
        // Nutzt HasContextFileReferences Trait
        $this->items = $this->galleryBoard->getFileReferencesArray();
    }

    /**
     * Leere Referenz-Hülle erstellen (öffnet NICHT das Modal)
     */
    public function addEmptyItem(): void
    {
        $this->galleryBoard->addEmptyFileReference([
            'title' => 'Neues Bild',
        ]);

        $this->loadItems();
    }

    /**
     * Klick auf Placeholder → Modal zum Zuweisen öffnen
     */
    public function assignFile(int $referenceId): void
    {
        $this->dispatch('terminal:files:assign', [
            'reference_id' => $referenceId,
        ]);
    }

    public function openFilePicker(): void
    {
        // Terminal übernimmt: Datei-Auswahl + Referenz-Erstellung
        $this->dispatch('terminal:files:pick', [
            'reference_type' => LocationGalleryBoard::class,
            'reference_id' => $this->galleryBoard->id,
            'multiple' => true,
        ]);
    }

    #[On('terminal:files:reference-created')]
    public function handleReferenceChanged(array $payload): void
    {
        // Nur prüfen ob es uns betrifft
        if (($payload['reference_type'] ?? null) !== LocationGalleryBoard::class) {
            return;
        }
        if (($payload['reference_id'] ?? null) !== $this->galleryBoard->id) {
            return;
        }

        // Einfach neu laden!
        $this->loadItems();
    }

    #[On('terminal:files:reference-updated')]
    public function handleReferenceUpdated(array $payload): void
    {
        $this->loadItems();
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

    public function updateItemTitle(int $referenceId, ?string $title): void
    {
        $reference = ContextFileReference::where('id', $referenceId)
            ->where('reference_type', LocationGalleryBoard::class)
            ->where('reference_id', $this->galleryBoard->id)
            ->first();

        if ($reference) {
            // Fallback auf Dateiname wenn leer
            if (empty(trim($title ?? ''))) {
                $title = $reference->contextFile?->original_name ?? 'Unbenannt';
            }

            $reference->update([
                'meta' => array_merge($reference->meta ?? [], ['title' => $title])
            ]);
        }

        $this->loadItems();
    }

    public function render()
    {
        return view('location::livewire.gallery-board.show')
            ->layout('platform::layouts.app');
    }
}
