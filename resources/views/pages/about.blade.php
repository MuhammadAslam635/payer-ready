<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>About PayerReady</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white min-h-screen flex flex-col">
    <x-web.header />

    <main class="flex-1">
        <section class="bg-primary-50 border-b border-primary-100">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
                <p class="text-primary-600 font-semibold uppercase tracking-wide">About Us</p>
                <h1 class="mt-3 text-3xl sm:text-4xl font-bold text-gray-900">
                    Built by credentialing veterans for modern provider groups
                </h1>
                <p class="mt-4 text-lg text-gray-600">
                    We’ve spent a decade building the playbooks, teams, and technology that keep multi-state medical groups credentialed and ready to scale.
                </p>
            </div>
        </section>

        <section class="py-16">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
                <x-web.stats />
                <x-web.why-choose-section />
            </div>
        </section>
    </main>

    <x-web.cta />
    <x-footer />
</body>
</html>

