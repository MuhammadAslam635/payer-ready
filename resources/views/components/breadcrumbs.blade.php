@props(['tagline' => 'Manage your professional credentials and reference providers'])
<div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Welcome back, {{ Auth::user()->name }}!</h1>
                <p class="text-slate-600 mt-1">{{ $tagline }}</p>
            </div>
            <div class="text-sm text-slate-500">
                Last updated: {{ now()->format('M d, Y \a\t g:i A') }}
            </div>
        </div>
    </div>
