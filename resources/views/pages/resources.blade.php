<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Resources & Support | PayerReady</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white min-h-screen flex flex-col">
    <x-web.header />

    <main class="flex-1">
        <section class="bg-white border-b border-gray-100">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
                <p class="text-primary-600 font-semibold uppercase tracking-wide">Resources</p>
                <h1 class="mt-3 text-3xl sm:text-4xl font-bold text-gray-900">
                    Guides, FAQs, and best practices for provider operations
                </h1>
                <p class="mt-4 text-lg text-gray-600">
                    Stay compliant, accelerate onboarding, and keep every credential current with our continually updated knowledge base.
                </p>
            </div>
        </section>

        <section class="py-16">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
                <x-web.faq />
                <x-web.testimonials />
            </div>
        </section>
    </main>

    <x-web.cta />
    <x-footer />
</body>
</html>

