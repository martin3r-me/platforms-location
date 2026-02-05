<x-ui-page>
    <x-slot name="navbar">
        <x-ui-page-navbar title="Mietpreise" icon="heroicon-o-banknotes" />
    </x-slot>

    <x-ui-page-container>
        <div class="space-y-6">
            {{-- Header --}}
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-[var(--ui-secondary)]">Mietpreise</h1>
                    <p class="text-[var(--ui-muted)] mt-1">Alle Pricing Boards im Team</p>
                </div>
            </div>

            {{-- Pricing Boards grouped by Location --}}
            @forelse($pricingGroups as $locationName => $pricings)
                <x-ui-panel :title="$locationName" :subtitle="count($pricings) . ' Pricing Board(s)'">
                    <div class="space-y-3">
                        @foreach($pricings as $pricing)
                            <div class="flex items-center justify-between p-4 rounded-md border border-[var(--ui-border)] bg-white hover:bg-[var(--ui-muted-5)] transition">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2">
                                        <h3 class="font-semibold text-[var(--ui-secondary)]">{{ $pricing->name }}</h3>
                                        @if($pricing->is_active)
                                            <span class="px-2 py-0.5 text-xs font-medium text-green-700 bg-green-100 rounded">Aktiv</span>
                                        @else
                                            <span class="px-2 py-0.5 text-xs font-medium text-gray-500 bg-gray-100 rounded">Inaktiv</span>
                                        @endif
                                        @if($pricing->done)
                                            <span class="px-2 py-0.5 text-xs font-medium text-green-700 bg-green-100 rounded">Erledigt</span>
                                        @endif
                                    </div>
                                    @if($pricing->description)
                                        <p class="text-sm text-[var(--ui-muted)] mt-1">{{ $pricing->description }}</p>
                                    @endif
                                    <div class="mt-2 flex items-center gap-4 text-xs text-[var(--ui-muted)]">
                                        @if($pricing->mietpreis_aufbautag)
                                            <span>Aufbau: {{ number_format($pricing->mietpreis_aufbautag, 2, ',', '.') }} EUR</span>
                                        @endif
                                        @if($pricing->mietpreis_abbautag)
                                            <span>Abbau: {{ number_format($pricing->mietpreis_abbautag, 2, ',', '.') }} EUR</span>
                                        @endif
                                        @if($pricing->mietpreis_va_tag)
                                            <span>VA-Tag: {{ number_format($pricing->mietpreis_va_tag, 2, ',', '.') }} EUR</span>
                                        @endif
                                    </div>
                                    <div class="mt-1 flex items-center gap-4 text-xs text-[var(--ui-muted)]">
                                        @if($pricing->valid_from || $pricing->valid_to)
                                            <span>
                                                Gueltigkeit: {{ $pricing->valid_from ? $pricing->valid_from->format('d.m.Y') : '–' }}
                                                – {{ $pricing->valid_to ? $pricing->valid_to->format('d.m.Y') : 'unbegrenzt' }}
                                            </span>
                                        @endif
                                        <span>Erstellt {{ $pricing->created_at->format('d.m.Y') }}</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <x-ui-button variant="secondary-outline" size="xs" :href="route('location.pricing-boards.show', $pricing)" wire:navigate>
                                        @svg('heroicon-o-pencil-square', 'w-4 h-4')
                                    </x-ui-button>
                                    <x-ui-button variant="danger-outline" size="xs" wire:click="delete({{ $pricing->id }})" wire:confirm="Pricing Board wirklich loeschen?">
                                        @svg('heroicon-o-trash', 'w-4 h-4')
                                    </x-ui-button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </x-ui-panel>
            @empty
                <div class="p-6 text-center text-[var(--ui-muted)] bg-white rounded-md border border-[var(--ui-border)]">
                    <p>Noch keine Pricing Boards vorhanden.</p>
                </div>
            @endforelse
        </div>
    </x-ui-page-container>

    <x-slot name="sidebar">
        <x-ui-page-sidebar title="Quick Access" width="w-80" :defaultOpen="true">
            <div class="p-6 space-y-6">
                {{-- Quick Actions --}}
                <div>
                    <h3 class="text-sm font-bold text-[var(--ui-secondary)] uppercase tracking-wider mb-3">Aktionen</h3>
                    <div class="space-y-2">
                        <x-ui-button variant="secondary-outline" size="sm" :href="route('location.dashboard')" wire:navigate class="w-full">
                            <span class="flex items-center gap-2">
                                @svg('heroicon-o-home', 'w-4 h-4')
                                Dashboard
                            </span>
                        </x-ui-button>
                    </div>
                </div>

                {{-- Quick Stats --}}
                <div>
                    <h3 class="text-sm font-bold text-[var(--ui-secondary)] uppercase tracking-wider mb-3">Statistiken</h3>
                    <div class="space-y-3">
                        <div class="p-3 bg-amber-50 rounded-lg border border-amber-100">
                            <div class="text-xs text-amber-600">Gesamt</div>
                            <div class="text-lg font-bold text-amber-700">{{ $totalCount }}</div>
                        </div>
                        <div class="p-3 bg-[var(--ui-muted-5)] rounded-lg border border-[var(--ui-border)]/40">
                            <div class="text-xs text-[var(--ui-muted)]">Locations</div>
                            <div class="text-lg font-bold text-[var(--ui-secondary)]">{{ count($pricingGroups) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </x-ui-page-sidebar>
    </x-slot>

    <x-slot name="activity">
        <x-ui-page-sidebar title="Aktivitaeten" width="w-80" :defaultOpen="false" storeKey="activityOpen" side="right">
            <div class="p-4 space-y-4">
                <div class="text-sm text-[var(--ui-muted)]">Letzte Aktivitaeten</div>
            </div>
        </x-ui-page-sidebar>
    </x-slot>
</x-ui-page>
