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
    <section id="home">
        <x-web.hero />
    </section>

    <!-- Stats Section -->
    <x-web.stats />

    <!-- Why Choose Us Section -->
    <section id="solutions">
        <x-web.why-choose-section />
    </section>

    <!-- Process Section -->
    <section id="how-it-works">
        <x-web.process-section />
    </section>

    <!-- Testimonials Section -->
    <x-web.testimonials />

    <!-- Comparison Section -->
    <section id="pricing">
        <x-web.comparison />
    </section>

    <!-- FAQ Section -->
    <section id="resources">
        <x-web.faq />
    </section>

    <!-- Final CTA Section -->
    <x-web.cta />

    <!-- Footer -->
    <section id="about">
        <x-footer />
    </section>

    <script>
        // Handle navigation clicks with smooth scroll
        function handleNavClick(event) {
            const href = event.currentTarget.getAttribute('href');
            
            // Check if it's an anchor link
            if (href && href.includes('#')) {
                const hash = href.split('#')[1];
                const currentPath = window.location.pathname;
                
                // If we're not on the home page, navigate first then scroll
                if (currentPath !== '/' && currentPath !== '') {
                    // Let the link navigate normally, scroll will happen on page load
                    return true;
                }
                
                // We're on the home page, handle smooth scroll
                event.preventDefault();
                
                const targetElement = document.getElementById(hash);
                
                if (targetElement) {
                    // Get the header height for offset
                    const headerHeight = document.querySelector('nav')?.offsetHeight || 0;
                    const targetPosition = targetElement.offsetTop - headerHeight;
                    
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                } else if (hash === 'home') {
                    // Scroll to top if home
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                }
                
                return false;
            }
            
            return true;
        }

        // Handle page load with hash in URL
        window.addEventListener('DOMContentLoaded', function() {
            if (window.location.hash) {
                const hash = window.location.hash.substring(1);
                const targetElement = document.getElementById(hash);
                
                if (targetElement) {
                    setTimeout(() => {
                        const headerHeight = document.querySelector('nav')?.offsetHeight || 0;
                        const targetPosition = targetElement.offsetTop - headerHeight;
                        
                        window.scrollTo({
                            top: targetPosition,
                            behavior: 'smooth'
                        });
                    }, 100);
                }
            }
        });
    </script>
</body>
</html>
