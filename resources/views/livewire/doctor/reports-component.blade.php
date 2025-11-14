<div class="space-y-6">
    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
        <div class="px-6 py-4 border-b border-slate-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">Reports</h1>
                    <p class="mt-1 text-sm text-slate-600">Filter by created date range, then download as PDF/CSV.</p>
                </div>
                <div class="mt-4 sm:mt-0">
                    <x-ui.button
                        type="button"
                        color="teal"
                        variant="primary"
                        icon="arrow-down-tray"
                        class="!px-5 uppercase tracking-wide text-xs"
                        wire:click="downloadReport">
                        Download
                    </x-ui.button>
                </div>
            </div>
        </div>
        <div class="px-6 py-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1">Start Date</label>
                    <x-ui.input type="date" wire:model.live="startDate" />
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1">End Date</label>
                    <x-ui.input type="date" wire:model.live="endDate" />
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">About</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Business/Clinic/Organization Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Group NPI</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Created At</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse($this->items as $item)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium {{ $item['category'] === 'License' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                    {{ $item['category'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $item['about'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">{{ $item['business_name'] ?? '—' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">{{ $item['group_npi'] ?? '—' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($item['created_at'])
                                    {{ $item['created_at']->format('M d, Y') }}
                                @else
                                    <span class="text-slate-400">N/A</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-sm text-slate-500">
                                No results found for the selected filters.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>


