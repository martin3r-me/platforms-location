<x-ui-page>
    <x-slot name="navbar">
        <x-ui-page-navbar title="Locations" icon="heroicon-o-map-pin" />
    </x-slot>

    <x-ui-page-container>
        <div class="space-y-6">
            {{-- Header --}}
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-[var(--ui-secondary)]">Locations</h1>
                    <p class="text-[var(--ui-muted)] mt-1">Verwalte deine Locations</p>
                </div>
            </div>

            {{-- Locations List --}}
            <x-ui-panel title="Locations" :subtitle="count($locations) . ' Location(s)'">
                <div class="space-y-3">
                    @forelse($locations as $location)
                        <div class="p-4 rounded-md border border-[var(--ui-border)] bg-white hover:bg-[var(--ui-muted-5)] transition">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-[var(--ui-secondary)]">{{ $location->name }}</h3>
                                    @if($location->description)
                                        <p class="text-sm text-[var(--ui-muted)] mt-1">{{ $location->description }}</p>
                                    @endif
                                    <div class="mt-2 flex items-center gap-4 text-xs text-[var(--ui-muted)]">
                                        <span>{{ $location->standorte()->count() }} Standort(e)</span>
                                        <span>{{ $location->created_at->format('d.m.Y') }}</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    @if($location->is_active)
                                        <span class="px-2 py-1 text-xs font-medium text-green-700 bg-green-100 rounded">Aktiv</span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-medium text-gray-700 bg-gray-100 rounded">Inaktiv</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-[var(--ui-muted)] bg-white rounded-md border border-[var(--ui-border)]">
                            <p>Noch keine Locations vorhanden.</p>
                        </div>
                    @endforelse
                </div>
            </x-ui-panel>
        </div>
    </x-ui-page-container>
</x-ui-page>
