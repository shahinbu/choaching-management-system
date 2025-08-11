<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        bangla: ['"Hind Siliguri"', 'sans-serif']
                    },
                    colors: {
                        primaryGreen: '#16a34a',
                        primaryOrange: '#f97316',
                        darkBlue: '#1a202c',
                    }
                }
            }
        }
    </script>

    <style>
        .custom-shadow {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        .dark .custom-shadow {
            box-shadow: 0 10px 15px -3px rgba(255, 255, 255, 0.05), 0 4px 6px -2px rgba(255, 255, 255, 0.025);
        }
        .sidebar-transition {
            transition: transform 0.3s ease-in-out;
        }
        .body-no-scroll {
            overflow: hidden;
        }
    </style>

    @stack('styles')
</head>
<body class="bg-gray-50 dark:bg-darkBlue text-gray-800 dark:text-gray-100 font-bangla flex flex-col min-h-screen">
    <!-- Header -->
    <header class="bg-primaryGreen dark:bg-green-800 text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 flex justify-between items-center py-4">
            <div class="flex items-center gap-3">
                <button id="sidebar-toggle" aria-label="Toggle Sidebar" class="md:hidden text-white focus:outline-none">
                    <svg id="hamburger-icon" class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg id="close-icon" class="w-8 h-8 hidden" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                <a href="{{ route('partner.dashboard') }}" class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full border-2 border-white shadow-md bg-white flex items-center justify-center">
                        <span class="text-primaryGreen font-bold text-xl">E</span>
                    </div>
                    <div class="hidden md:block">
                        <h1 class="text-xl font-bold">Exam System</h1>
                        <p class="text-xs italic opacity-90">Smart Exam Management</p>
                    </div>
                </a>
            </div>
            <nav class="hidden md:flex space-x-8 font-semibold text-lg">
                <a href="{{ route('partner.dashboard') }}" class="hover:text-green-200 transition-colors duration-200">হোম</a>
                <a href="#" class="hover:text-green-200 transition-colors duration-200">আমাদের সম্পর্কে</a>
                <a href="#" class="hover:text-green-200 transition-colors duration-200">যোগাযোগ</a>
            </nav>
            <div class="flex items-center gap-3">
                <button id="darkToggle" aria-label="Toggle Dark Mode" title="Toggle Dark Mode"
                    class="bg-white text-black dark:bg-gray-700 dark:text-white p-2 rounded-full shadow hover:scale-110 transition-transform">
                    🌙
                </button>
            </div>
        </div>
    </header>

    <div class="flex flex-1">
        <!-- Sidebar -->
        <aside id="sidebar"
            class="sidebar-transition fixed top-0 left-0 h-full w-64 bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-white p-6 z-50 transform -translate-x-full md:translate-x-0 md:relative md:flex-shrink-0 md:rounded-3xl md:border-r md:border-gray-300 dark:md:border-gray-700">
            <div class="h-20 md:hidden"></div>
            <div class="flex items-center justify-center h-24 mb-10 hidden md:flex">
                <a href="#" class="flex items-center gap-3">
                    <div class="w-16 h-16 rounded-full border-2 border-primaryGreen shadow-md bg-white flex items-center justify-center">
                        <span class="text-primaryGreen font-bold text-2xl">P</span>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-primaryGreen">Partner</h1>
                        <p class="text-sm italic opacity-90">Dashboard</p>
                    </div>
                </a>
            </div>

            <!-- Navigation Menu -->
            <nav class="space-y-2">
                <a href="{{ route('partner.dashboard') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-primaryGreen hover:text-white transition-colors duration-200 {{ request()->routeIs('partner.dashboard') ? 'bg-primaryGreen text-white' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                    </svg>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('partner.courses.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-primaryGreen hover:text-white transition-colors duration-200 {{ request()->routeIs('partner.courses.*') ? 'bg-primaryGreen text-white' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <span>Courses</span>
                </a>

                <a href="{{ route('partner.subjects.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-primaryGreen hover:text-white transition-colors duration-200 {{ request()->routeIs('partner.subjects.*') ? 'bg-primaryGreen text-white' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    <span>Subjects</span>
                </a>

                <a href="{{ route('partner.topics.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-primaryGreen hover:text-white transition-colors duration-200 {{ request()->routeIs('partner.topics.*') ? 'bg-primaryGreen text-white' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    <span>Topics</span>
                </a>

                <a href="{{ route('partner.questions.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-primaryGreen hover:text-white transition-colors duration-200 {{ request()->routeIs('partner.questions.*') ? 'bg-primaryGreen text-white' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Questions</span>
                </a>

                <a href="{{ route('partner.question-sets.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-primaryGreen hover:text-white transition-colors duration-200 {{ request()->routeIs('partner.question-sets.*') ? 'bg-primaryGreen text-white' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>Question Sets</span>
                </a>

                <a href="{{ route('partner.exams.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-primaryGreen hover:text-white transition-colors duration-200 {{ request()->routeIs('partner.exams.*') ? 'bg-primaryGreen text-white' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <span>Exams</span>
                </a>

                <a href="{{ route('partner.students.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-primaryGreen hover:text-white transition-colors duration-200 {{ request()->routeIs('partner.students.*') ? 'bg-primaryGreen text-white' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                    <span>Students</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
        // Dark mode toggle
        const darkToggle = document.getElementById('darkToggle');
        const html = document.documentElement;
        
        // Check for saved dark mode preference
        if (localStorage.getItem('darkMode') === 'true' || 
            (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            html.classList.add('dark');
        }

        darkToggle.addEventListener('click', () => {
            html.classList.toggle('dark');
            localStorage.setItem('darkMode', html.classList.contains('dark'));
        });

        // Sidebar toggle for mobile
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebar = document.getElementById('sidebar');
        const hamburgerIcon = document.getElementById('hamburger-icon');
        const closeIcon = document.getElementById('close-icon');

        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            hamburgerIcon.classList.toggle('hidden');
            closeIcon.classList.toggle('hidden');
            document.body.classList.toggle('body-no-scroll');
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', (e) => {
            if (window.innerWidth < 768 && 
                !sidebar.contains(e.target) && 
                !sidebarToggle.contains(e.target) && 
                !sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.add('-translate-x-full');
                hamburgerIcon.classList.remove('hidden');
                closeIcon.classList.add('hidden');
                document.body.classList.remove('body-no-scroll');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
