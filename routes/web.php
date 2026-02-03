<?php

use Platform\Location\Livewire\Dashboard;
use Platform\Location\Livewire\Sidebar;
use Platform\Location\Livewire\Location\Index as LocationIndex;
use Platform\Location\Livewire\Site\Index as SiteIndex;

Route::get('/', Dashboard::class)->name('location.dashboard');
Route::get('/locations', LocationIndex::class)->name('location.locations.index');
Route::get('/sites', SiteIndex::class)->name('location.sites.index');
