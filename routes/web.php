<?php

use Platform\Location\Livewire\Dashboard;
use Platform\Location\Livewire\Sidebar;
use Platform\Location\Livewire\Location\Index as LocationIndex;
use Platform\Location\Livewire\Standort\Index as StandortIndex;

Route::get('/', Dashboard::class)->name('location.dashboard');
Route::get('/locations', LocationIndex::class)->name('location.locations.index');
Route::get('/standorte', StandortIndex::class)->name('location.standorte.index');
