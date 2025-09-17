<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PayerReady - Expert-Led Credentialing & Compliance</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-white">
    <!-- Header -->
    <x-web.header />

    <!-- Hero Section -->
    <x-web.hero />

    <!-- Stats Section -->
    <x-web.stats />

    <!-- Why Choose Us Section -->
    <x-web.why-choose-section />

    <!-- Process Section -->
    <x-web.process-section />

    <!-- Testimonials Section -->
    <x-web.testimonials />

    <!-- Comparison Section -->
    <x-web.comparison />

    <!-- FAQ Section -->
    <x-web.faq />

    <!-- Final CTA Section -->
    <x-web.cta />

    <!-- Footer -->
    <x-footer />
</body>
</html>
