<?php

namespace Platform\Location\Livewire\Settings;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Platform\Location\Models\LocationOccasion;

class OccasionCreate extends Component
{
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

    public function save()
    {
        $this->validate();

        $user = Auth::user();
        $team = $user->currentTeam;

        $occasion = LocationOccasion::create([
            'name' => $this->name,
            'description' => $this->description ?: null,
            'is_active' => $this->is_active,
            'user_id' => $user->id,
            'team_id' => $team->id,
        ]);

        $this->dispatch('notifications:store', [
            'title' => 'Occasion created',
            'message' => 'The occasion has been created.',
            'notice_type' => 'success',
            'noticable_type' => LocationOccasion::class,
            'noticable_id' => $occasion->id,
        ]);

        $this->redirect(route('location.settings.occasions.index'), navigate: true);
    }

    public function render()
    {
        return view('location::livewire.settings.occasion.create')
            ->layout('platform::layouts.app');
    }
}
