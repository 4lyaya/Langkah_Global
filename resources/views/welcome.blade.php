<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>LangkahGlobal - Modern Social Blog Platform</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <style>
        [x-cloak] {
            display: none !important;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        @keyframes typing {
            from {
                width: 0;
            }

            to {
                width: 100%;
            }
        }

        @keyframes blink {
            50% {
                border-color: transparent;
            }
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .animate-fade-in-up {
            animation: fadeInUp 1s ease-out;
        }

        .animate-fade-in-left {
            animation: fadeInLeft 1s ease-out;
        }

        .animate-fade-in-right {
            animation: fadeInRight 1s ease-out;
        }

        .animate-pulse-slow {
            animation: pulse 3s ease-in-out infinite;
        }

        .animate-gradient {
            animation: gradient 15s ease infinite;
        }

        .typing-animation {
            overflow: hidden;
            border-right: 3px solid;
            white-space: nowrap;
            animation: typing 3.5s steps(40, end), blink 1s step-end infinite;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .text-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-gradient {
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 400% 400%;
        }
    </style>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased" x-data="{ currentSection: 1, showMobileMenu: false }">
    <!-- Animated Background -->
    <div class="fixed inset-0 hero-gradient animate-gradient -z-10"></div>

    <!-- Navigation -->
    <nav class="fixed w-full z-50 glass-effect">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex-shrink-0 animate-fade-in-left">
                    <span class="text-2xl font-bold text-white">Langkah<span class="text-blue-400">Global</span></span>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-white hover:text-blue-300 transition-colors duration-300"
                        @click="currentSection = 2">Features</a>
                    <a href="#about" class="text-white hover:text-blue-300 transition-colors duration-300"
                        @click="currentSection = 3">About</a>
                    <a href="#contact" class="text-white hover:text-blue-300 transition-colors duration-300"
                        @click="currentSection = 4">Contact</a>

                    <div class="flex items-center space-x-4">
                        <a href="{{ route('login') }}"
                            class="text-white hover:text-blue-300 transition-colors duration-300">Login</a>
                        <a href="{{ route('register') }}"
                            class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-all duration-300 transform hover:scale-105">
                            Get Started
                        </a>
                    </div>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button @click="showMobileMenu = !showMobileMenu" class="text-white">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                :d="showMobileMenu ? 'M6 18L18 6M6 6l12 12' : 'M4 6h16M4 12h16M4 18h16'"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div x-show="showMobileMenu" x-cloak class="md:hidden glass-effect">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="#features" class="block px-3 py-2 text-white hover:text-blue-300"
                    @click="showMobileMenu = false">Features</a>
                <a href="#about" class="block px-3 py-2 text-white hover:text-blue-300"
                    @click="showMobileMenu = false">About</a>
                <a href="#contact" class="block px-3 py-2 text-white hover:text-blue-300"
                    @click="showMobileMenu = false">Contact</a>
                <div class="border-t border-white/20 pt-2">
                    <a href="{{ route('login') }}" class="block px-3 py-2 text-white hover:text-blue-300">Login</a>
                    <a href="{{ route('register') }}" class="block px-3 py-2 text-blue-300 font-semibold">Get
                        Started</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="hero" class="min-h-screen flex items-center justify-center relative overflow-hidden">
        <div class="absolute inset-0 bg-black/40"></div>

        <div class="relative z-10 text-center px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto">
            <!-- Animated Typing Text -->
            <h1 class="text-4xl sm:text-6xl lg:text-7xl font-bold text-white mb-6 typing-animation mx-auto"
                style="width: fit-content;">
                Welcome to LangkahGlobal
            </h1>

            <p class="text-xl sm:text-2xl text-blue-100 mb-8 animate-fade-in-up" style="animation-delay: 0.5s;">
                The modern social blog platform where your voice matters
            </p>

            <div class="animate-fade-in-up" style="animation-delay: 1s;">
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="{{ route('register') }}"
                        class="bg-blue-600 text-white px-8 py-4 rounded-lg text-lg font-semibold hover:bg-blue-700 transition-all duration-300 transform hover:scale-105 animate-pulse-slow">
                        Start Your Journey
                    </a>
                    <a href="#features"
                        class="text-white border-2 border-white px-8 py-4 rounded-lg text-lg font-semibold hover:bg-white hover:text-blue-600 transition-all duration-300">
                        Explore Features
                    </a>
                </div>
            </div>

            <!-- Animated Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mt-16 animate-fade-in-up" style="animation-delay: 1.5s;">
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-white mb-2" x-data="{ count: 0 }"
                        x-init="setTimeout(() => {
                            let interval = setInterval(() => {
                                if (count < 10000) count += 100;
                                else clearInterval(interval);
                            }, 1);
                        }, 2000)" x-text="count.toLocaleString()">0</div>
                    <p class="text-blue-200">Active Users</p>
                </div>
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-white mb-2" x-data="{ count: 0 }"
                        x-init="setTimeout(() => {
                            let interval = setInterval(() => {
                                if (count < 250000) count += 1000;
                                else clearInterval(interval);
                            }, 1);
                        }, 2500)" x-text="count.toLocaleString()">0</div>
                    <p class="text-blue-200">Posts Shared</p>
                </div>
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-white mb-2" x-data="{ count: 0 }"
                        x-init="setTimeout(() => {
                            let interval = setInterval(() => {
                                if (count < 500000) count += 2000;
                                else clearInterval(interval);
                            }, 1);
                        }, 3000)" x-text="count.toLocaleString()">0</div>
                    <p class="text-blue-200">Connections Made</p>
                </div>
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-white mb-2" x-data="{ count: 0 }"
                        x-init="setTimeout(() => {
                            let interval = setInterval(() => {
                                if (count < 150) count += 1;
                                else clearInterval(interval);
                            }, 20);
                        }, 3500)" x-text="count">0</div>
                    <p class="text-blue-200">Countries</p>
                </div>
            </div>
        </div>

        <!-- Floating Elements -->
        <div class="absolute top-1/4 left-1/4 w-8 h-8 bg-blue-400 rounded-full opacity-20 animate-float"
            style="animation-delay: 0s;"></div>
        <div class="absolute top-1/3 right-1/4 w-12 h-12 bg-purple-400 rounded-full opacity-30 animate-float"
            style="animation-delay: 2s;"></div>
        <div class="absolute bottom-1/4 left-1/3 w-10 h-10 bg-pink-400 rounded-full opacity-25 animate-float"
            style="animation-delay: 4s;"></div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-white/95 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 animate-fade-in-up">Powerful Features</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto animate-fade-in-up" style="animation-delay: 0.3s;">
                    Discover why thousands of creators choose LangkahGlobal for their social blogging journey
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div
                    class="bg-gradient-to-br from-blue-50 to-purple-50 p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-4">Modern Blogging</h3>
                    <p class="text-gray-600 mb-4">Create beautiful posts with rich text editor and multimedia support.
                    </p>
                    <ul class="space-y-2 text-gray-500">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            Rich text formatting
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            Image and video support
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            Draft and scheduling
                        </li>
                    </ul>
                </div>

                <!-- Feature 2 -->
                <div
                    class="bg-gradient-to-br from-green-50 to-blue-50 p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-4">Social Network</h3>
                    <p class="text-gray-600 mb-4">Connect with like-minded people and build your community.</p>
                    <ul class="space-y-2 text-gray-500">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            Follow system
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            Direct messaging
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            Groups and communities
                        </li>
                    </ul>
                </div>

                <!-- Feature 3 -->
                <div
                    class="bg-gradient-to-br from-purple-50 to-pink-50 p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-4">Real-time Updates</h3>
                    <p class="text-gray-600 mb-4">Stay connected with instant notifications and live updates.</p>
                    <ul class="space-y-2 text-gray-500">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            Live notifications
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            Real-time comments
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            Activity feed
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-blue-600 to-purple-600 relative overflow-hidden">
        <div class="absolute inset-0 bg-black/20"></div>
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">Ready to Start Your Journey?</h2>
            <p class="text-xl text-blue-100 mb-8 max-w-3xl mx-auto">
                Join thousands of creators who are already sharing their stories and building communities on
                LangkahGlobal.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}"
                    class="bg-white text-blue-600 px-8 py-4 rounded-lg text-lg font-semibold hover:bg-gray-100 transition-all duration-300 transform hover:scale-105">
                    Create Account
                </a>
                <a href="{{ route('login') }}"
                    class="border-2 border-white text-white px-8 py-4 rounded-lg text-lg font-semibold hover:bg-white hover:text-blue-600 transition-all duration-300">
                    Sign In
                </a>
            </div>
        </div>

        <!-- Animated circles -->
        <div
            class="absolute top-0 left-0 w-64 h-64 bg-white/10 rounded-full -translate-x-32 -translate-y-32 animate-pulse">
        </div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-white/5 rounded-full translate-x-48 translate-y-48 animate-pulse"
            style="animation-delay: 1.5s;"></div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <span class="text-2xl font-bold">Langkah<span class="text-blue-400">Global</span></span>
                    <p class="text-gray-400 mt-4">The modern social blog platform for creators and communities.</p>
                </div>

                <div>
                    <h4 class="text-lg font-semibold mb-4">Platform</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#features" class="hover:text-white transition-colors">Features</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Pricing</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">API</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-semibold mb-4">Company</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors">About</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Blog</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Careers</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-semibold mb-4">Support</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors">Help Center</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Terms of Service</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2024 LangkahGlobal. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Initialize animations with GSAP
        document.addEventListener('DOMContentLoaded', function() {
            // Animate elements on scroll
            gsap.registerPlugin(ScrollTrigger);

            // Animate feature cards
            gsap.utils.toArray('.bg-gradient-to-br').forEach(card => {
                gsap.fromTo(card, {
                    y: 100,
                    opacity: 0
                }, {
                    y: 0,
                    opacity: 1,
                    duration: 0.8,
                    scrollTrigger: {
                        trigger: card,
                        start: 'top 80%',
                        toggleActions: 'play none none reverse'
                    }
                });
            });

            // Parallax effect for hero section
            gsap.to('.hero-gradient', {
                backgroundPosition: '50% 100%',
                ease: 'none',
                scrollTrigger: {
                    trigger: '#hero',
                    start: 'top top',
                    end: 'bottom top',
                    scrub: true
                }
            });

            // Animated counter for stats
            const counters = document.querySelectorAll('[x-data]');
            counters.forEach(counter => {
                const target = parseInt(counter.textContent);

                // Skip kalau bukan angka valid
                if (isNaN(target)) {
                    return;
                }

                const duration = 2000;
                const increment = target / duration * 10;

                let current = 0;
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        counter.textContent = target.toLocaleString();
                        clearInterval(timer);
                    } else {
                        counter.textContent = Math.floor(current).toLocaleString();
                    }
                }, 10);
            });
        });
    </script>
</body>

</html>
