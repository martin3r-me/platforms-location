<x-ui-page>
    <x-slot name="navbar">
        <x-ui-page-navbar title="Occasions" icon="heroicon-o-calendar-days" />
    </x-slot>

    <x-ui-page-container>
        <div class="space-y-6">
            {{-- Header --}}
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-[var(--ui-secondary)]">Occasions</h1>
                    <p class="text-[var(--ui-muted)] mt-1">Manage your occasions</p>
                </div>
                <x-ui-button variant="success" size="sm" :href="route('location.settings.occasions.create')" wire:navigate>
                    <span class="inline-flex items-center gap-2">
                        @svg('heroicon-o-plus', 'w-4 h-4')
                        <span>New Occasion</span>
                    </span>
                </x-ui-button>
            </div>

            {{-- Occasions List --}}
            <x-ui-panel title="Occasions" :subtitle="count($occasions) . ' Occasion(s)'">
                <div class="space-y-3">
                    @forelse($occasions as $occasion)
                        <div class="flex items-center justify-between p-4 rounded-md border border-[var(--ui-border)] bg-white hover:bg-[var(--ui-muted-5)] transition">
                            <div class="flex-1">
                                <div class="flex items-center gap-2">
                                    <h3 class="font-semibold text-[var(--ui-secondary)]">{{ $occasion->name }}</h3>
                                    @if($occasion->is_active)
                                        <span class="px-2 py-0.5 text-xs font-medium text-green-700 bg-green-100 rounded">Active</span>
                                    @else
                                        <span class="px-2 py-0.5 text-xs font-medium text-gray-500 bg-gray-100 rounded">Inactive</span>
                                    @endif
                                </div>
                                @if($occasion->description)
                                    <p class="text-sm text-[var(--ui-muted)] mt-1">{{ $occasion->description }}</p>
                                @endif
                                <div class="mt-2 text-xs text-[var(--ui-muted)]">
                                    Created {{ $occasion->created_at->format('d.m.Y') }}
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <x-ui-button variant="secondary-outline" size="xs" :href="route('location.settings.occasions.edit', $occasion)" wire:navigate>
                                    @svg('heroicon-o-pencil-square', 'w-4 h-4')
                                </x-ui-button>
                                <x-ui-button variant="danger-outline" size="xs" wire:click="delete({{ $occasion->id }})" wire:confirm="Are you sure you want to delete this occasion?">
                                    @svg('heroicon-o-trash', 'w-4 h-4')
                                </x-ui-button>
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-[var(--ui-muted)] bg-white rounded-md border border-[var(--ui-border)]">
                            <p>No occasions yet.</p>
                        </div>
                    @endforelse
                </div>
            </x-ui-panel>
        </div>
    </x-ui-page-container>

    <x-slot name="sidebar">
        <x-ui-page-sidebar title="Quick Access" width="w-80" :defaultOpen="true">
            <div class="p-6 space-y-6">
                {{-- Quick Actions --}}
                <div>
                    <h3 class="text-sm font-bold text-[var(--ui-secondary)] uppercase tracking-wider mb-3">Actions</h3>
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
                    <h3 class="text-sm font-bold text-[var(--ui-secondary)] uppercase tracking-wider mb-3">Statistics</h3>
                    <div class="space-y-3">
                        <div class="p-3 bg-[var(--ui-muted-5)] rounded-lg border border-[var(--ui-border)]/40">
                            <div class="text-xs text-[var(--ui-muted)]">Total</div>
                            <div class="text-lg font-bold text-[var(--ui-secondary)]">{{ count($occasions) }}</div>
                        </div>
                        <div class="p-3 bg-[var(--ui-muted-5)] rounded-lg border border-[var(--ui-border)]/40">
                            <div class="text-xs text-[var(--ui-muted)]">Active</div>
                            <div class="text-lg font-bold text-[var(--ui-secondary)]">{{ $occasions->where('is_active', true)->count() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </x-ui-page-sidebar>
    </x-slot>

    <x-slot name="activity">
        <x-ui-page-sidebar title="Activities" width="w-80" :defaultOpen="false" storeKey="activityOpen" side="right">
            <div class="p-4 space-y-4">
                <div class="text-sm text-[var(--ui-muted)]">Recent activities</div>
            </div>
        </x-ui-page-sidebar>
    </x-slot>
</x-ui-page>
