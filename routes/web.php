<?php

use Platform\Location\Livewire\Dashboard;
use Platform\Location\Livewire\Sidebar;
use Platform\Location\Livewire\Location\Index as LocationIndex;
use Platform\Location\Livewire\Location\Show as LocationShow;
use Platform\Location\Livewire\Site\Index as SiteIndex;
use Platform\Location\Livewire\Site\Locations as SiteLocations;
use Platform\Location\Livewire\ContentBoard\Show as ContentBoardShow;
use Platform\Location\Livewire\GalleryBoard\Show as GalleryBoardShow;
use Platform\Location\Livewire\MetaBoard\Show as MetaBoardShow;
use Platform\Location\Livewire\Settings\OccasionIndex;
use Platform\Location\Livewire\Settings\OccasionCreate;
use Platform\Location\Livewire\Settings\OccasionEdit;
use Platform\Location\Livewire\Settings\SeatingIndex;
use Platform\Location\Livewire\Settings\SeatingCreate;
use Platform\Location\Livewire\Settings\SeatingEdit;
use Platform\Location\Livewire\PricingBoard\Show as PricingBoardShow;
use Platform\Location\Livewire\Settings\PricingIndex;

Route::get('/', Dashboard::class)->name('location.dashboard');
Route::get('/locations', LocationIndex::class)->name('location.locations.index');
Route::get('/sites', SiteIndex::class)->name('location.sites.index');
Route::get('/sites/{site}/locations', SiteLocations::class)->name('location.sites.locations');
Route::get('/locations/{location}', LocationShow::class)->name('location.locations.show');
Route::get('/content-boards/{contentBoard}', ContentBoardShow::class)->name('location.content-boards.show');
Route::get('/gallery-boards/{galleryBoard}', GalleryBoardShow::class)->name('location.gallery-boards.show');
Route::get('/meta-boards/{metaBoard}', MetaBoardShow::class)->name('location.meta-boards.show');
Route::get('/pricing-boards/{pricingBoard}', PricingBoardShow::class)->name('location.pricing-boards.show');

// Settings
Route::get('/settings/occasions', OccasionIndex::class)->name('location.settings.occasions.index');
Route::get('/settings/occasions/create', OccasionCreate::class)->name('location.settings.occasions.create');
Route::get('/settings/occasions/{occasion}/edit', OccasionEdit::class)->name('location.settings.occasions.edit');

Route::get('/settings/seatings', SeatingIndex::class)->name('location.settings.seatings.index');
Route::get('/settings/seatings/create', SeatingCreate::class)->name('location.settings.seatings.create');
Route::get('/settings/seatings/{seating}/edit', SeatingEdit::class)->name('location.settings.seatings.edit');

Route::get('/settings/pricings', PricingIndex::class)->name('location.settings.pricings.index');
