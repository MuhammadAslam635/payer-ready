<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pricing & Plans | PayerReady</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white min-h-screen flex flex-col">
    <x-web.header />

    <main class="flex-1">
        <section class="bg-primary-700 text-white">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
                <p class="text-primary-100 font-semibold uppercase tracking-wide">Pricing</p>
                <h1 class="mt-3 text-3xl sm:text-4xl font-bold">
                    Transparent pricing for every growth stage
                </h1>
                <p class="mt-4 text-lg text-primary-100/80">
                    Only pay for the services you need—no surprise fees, no long-term contracts.
                </p>
            </div>
        </section>

        <section class="py-16 bg-gray-50">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
                <x-web.comparison />
                <div class="bg-white rounded-2xl shadow-sm p-8">
                    <h2 class="text-2xl font-semibold text-gray-900">Need a custom quote?</h2>
                    <p class="mt-2 text-gray-600">
                        Enterprise networks, multi-state groups, and hospital partners can contact us for tailored pricing and SLA-backed support.
                    </p>
                    <a href="{{ route('register') }}" class="inline-flex items-center mt-6 px-6 py-3 bg-primary-600 text-white font-semibold rounded-lg hover:bg-primary-700 transition-colors">
                        Talk to sales
                    </a>
                </div>
            </div>
        </section>
    </main>

    <x-web.cta />
    <x-footer />
</body>
</html>

