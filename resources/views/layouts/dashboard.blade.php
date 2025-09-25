<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PayerReady') }} - @yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('css')
    @livewireStyles
</head>
<body class="font-sans antialiased bg-slate-50" x-data="{ sidebarOpen: false }">
    <div class="h-screen flex bg-slate-100">
        <!-- Mobile sidebar overlay -->
        <div x-show="sidebarOpen"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 flex z-40 lg:hidden"
             style="display: none;">
            <div class="fixed inset-0 bg-gray-600 bg-opacity-75" @click="sidebarOpen = false"></div>
        </div>

        <!-- Sidebar -->
        <div class="hidden lg:flex lg:flex-shrink-0">
            <x-sidebar />
        </div>

        <!-- Mobile sidebar -->
        <div x-show="sidebarOpen"
             x-transition:enter="transition ease-in-out duration-300 transform"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in-out duration-300 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full"
             class="relative flex-1 flex flex-col max-w-xs w-full bg-primary-700 z-50 lg:hidden"
             style="display: none;">
            <x-sidebar />
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <x-ui.toast progressBarVariant="thin" />
            <!-- Header -->
            <x-dashboard-header />

            <!-- Main Content Area -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-100 p-4 sm:p-6 lg:p-8">
                <!-- Breadcrumbs -->
                @if(isset($breadcrumbs))
                    <x-breadcrumbs :breadcrumbs="$breadcrumbs" />
                @endif

                <!-- Page Content -->
                {{ $slot }}
            </main>
        </div>
    </div>

    <!-- Notifications -->
    {{-- <x-notifications /> --}}

    @stack('modals')
    @stack('js')
    @livewireScripts
</body>
</html>
