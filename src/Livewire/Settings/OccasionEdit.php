<?php

namespace Platform\Location\Livewire\Settings;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Platform\Location\Models\LocationOccasion;

class OccasionEdit extends Component
{
    public LocationOccasion $occasion;

    public $name = '';
    public $description = '';
    public $is_active = true;

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ];
    }

    public function mount(LocationOccasion $occasion)
    {
        $user = Auth::user();
        $team = $user->currentTeam;

        abort_unless($occasion->team_id === $team->id, 403);

        $this->occasion = $occasion;
        $this->name = $occasion->name;
        $this->description = $occasion->description ?? '';
        $this->is_active = $occasion->is_active;
    }

    public function save()
    {
        $this->validate();

        $this->occasion->update([
            'name' => $this->name,
            'description' => $this->description ?: null,
            'is_active' => $this->is_active,
        ]);

        $this->dispatch('notifications:store', [
            'title' => 'Occasion updated',
            'message' => 'The occasion has been updated.',
            'notice_type' => 'success',
            'noticable_type' => LocationOccasion::class,
            'noticable_id' => $this->occasion->id,
        ]);

        $this->redirect(route('location.settings.occasions.index'), navigate: true);
    }

    public function render()
    {
        return view('location::livewire.settings.occasion.edit')
            ->layout('platform::layouts.app');
    }
}
