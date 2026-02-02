<x-ui-page>
    <x-slot name="navbar">
        <x-ui-page-navbar title="Standorte" icon="heroicon-o-map-pin" />
    </x-slot>

    <x-ui-page-container>
        <div class="space-y-6">
            {{-- Header --}}
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-[var(--ui-secondary)]">Standorte</h1>
                    <p class="text-[var(--ui-muted)] mt-1">Verwalte deine Standorte</p>
                </div>
            </div>

            {{-- Standorte List --}}
            <x-ui-panel title="Standorte" :subtitle="count($standorte) . ' Standort(e)'">
                <div class="space-y-3">
                    @forelse($standorte as $standort)
                        <div class="p-4 rounded-md border border-[var(--ui-border)] bg-white hover:bg-[var(--ui-muted-5)] transition">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2">
                                        <h3 class="font-semibold text-[var(--ui-secondary)]">{{ $standort->name }}</h3>
                                        @if($standort->is_international)
                                            <span class="px-2 py-1 text-xs font-medium text-blue-700 bg-blue-100 rounded">International</span>
                                        @endif
                                    </div>
                                    @if($standort->description)
                                        <p class="text-sm text-[var(--ui-muted)] mt-1">{{ $standort->description }}</p>
                                    @endif
                                    
                                    {{-- Adresse --}}
                                    @if($standort->full_address)
                                        <div class="mt-2 text-sm text-[var(--ui-secondary)]">
                                            <span class="font-medium">Adresse:</span> {{ $standort->full_address }}
                                        </div>
                                    @endif
                                    
                                    {{-- GPS --}}
                                    @if($standort->latitude && $standort->longitude)
                                        <div class="mt-1 text-xs text-[var(--ui-muted)]">
                                            GPS: {{ number_format($standort->latitude, 6) }}, {{ number_format($standort->longitude, 6) }}
                                        </div>
                                    @endif
                                    
                                    {{-- Location --}}
                                    @if($standort->location)
                                        <div class="mt-1 text-xs text-[var(--ui-muted)]">
                                            Location: {{ $standort->location->name }}
                                        </div>
                                    @endif
                                    
                                    <div class="mt-2 flex items-center gap-4 text-xs text-[var(--ui-muted)]">
                                        @if($standort->country_code)
                                            <span>{{ $standort->country_code }}</span>
                                        @endif
                                        @if($standort->timezone)
                                            <span>{{ $standort->timezone }}</span>
                                        @endif
                                        <span>{{ $standort->created_at->format('d.m.Y') }}</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    @if($standort->is_active)
                                        <span class="px-2 py-1 text-xs font-medium text-green-700 bg-green-100 rounded">Aktiv</span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-medium text-gray-700 bg-gray-100 rounded">Inaktiv</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-[var(--ui-muted)] bg-white rounded-md border border-[var(--ui-border)]">
                            <p>Noch keine Standorte vorhanden.</p>
                        </div>
                    @endforelse
                </div>
            </x-ui-panel>
        </div>
    </x-ui-page-container>
</x-ui-page>
