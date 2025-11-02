<div class="space-y-6">
    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
        <div class="px-6 py-4 border-b border-slate-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">Licensing (Read-only)</h1>
                    <p class="mt-1 text-sm text-slate-600">Doctor licenses in your organization.</p>
                </div>
            </div>
        </div>

        <div class="px-6 py-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                <div class="flex-1 max-w-lg">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <x-ui.icon name="magnifying-glass" class="h-5 w-5 text-slate-400" />
                        </div>
                        <input wire:model.live="search" type="text"
                            class="block w-full pl-10 pr-3 py-2 border border-slate-300 rounded-md leading-5 bg-white placeholder-slate-500 focus:outline-none focus:placeholder-slate-400 focus:ring-1 focus:ring-teal-500 focus:border-teal-500 sm:text-sm"
                            placeholder="Search by license type, number, state, or doctor...">
                    </div>
                </div>
                <div>
                    <select wire:model.live="perPage" class="text-sm border-slate-300 rounded-md focus:ring-teal-500 focus:border-teal-500">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Doctor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Number</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">State</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Issue</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Expires</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse($licenses as $license)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $license->user->name ?? '—' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $license->licenseType->name ?? '—' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $license->license_number ?? '—' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $license->state->name ?? '—' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ optional($license->issue_date)->format('M d, Y') ?? '—' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ optional($license->expiration_date)->format('M d, Y') ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="text-slate-500">
                                    <x-ui.icon name="document-text" class="mx-auto h-12 w-12 text-slate-400" />
                                    <h3 class="mt-2 text-sm font-medium text-slate-900">No licenses found</h3>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4">{{ $licenses->links() }}</div>
    </div>
</div>


