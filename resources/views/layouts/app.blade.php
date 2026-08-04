<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'AI Buddy - Sahabat Belajar Interaktif')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Quicksand:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Laravel Vite Asset Compiler -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-15px) rotate(2deg);
            }
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .animate-float-delay {
            animation: float 6s ease-in-out 2s infinite;
        }
    </style>
</head>

<body class="bg-cream-bg text-slate-900 min-h-screen font-sans antialiased">

    <!-- Background Ambient Glowing Orbs -->
    <div
        class="fixed top-0 left-0 w-96 h-96 bg-terracotta/10 rounded-full filter blur-[100px] -z-10 animate-float pointer-events-none">
    </div>
    <div
        class="fixed bottom-0 right-0 w-[450px] h-[450px] bg-amber-500/10 rounded-full filter blur-[120px] -z-10 animate-float-delay pointer-events-none">
    </div>

    <div class="min-h-screen flex">
        <!-- Modular Component: Sidebar -->
        @include('partials.sidebar')

        <!-- Mobile Sidebar Backdrop Overlay -->
        <div id="sidebarBackdrop" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-30 hidden md:hidden"></div>

        <!-- Main Content Area -->
        <div id="userMainContent" class="flex-1 md:ml-64 flex flex-col min-w-0 min-h-screen transition-all duration-300">
            <!-- Modular Component: Header Top Bar -->
            @include('partials.header')

            <!-- Main Page Content -->
            <main class="flex-1 p-4 md:p-8">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Global App JavaScript (Fullstack - Session Auth) -->
    <script>
        // Force Light Theme
        document.documentElement.classList.remove('dark');
        localStorage.removeItem('theme');

        // Sidebar Elements & State Handlers
        const mobileToggle = document.getElementById('mobileSidebarToggle');
        const userDesktopToggle = document.getElementById('userDesktopToggle');
        const sidebar = document.getElementById('appSidebar');
        const userMainContent = document.getElementById('userMainContent');
        const backdrop = document.getElementById('sidebarBackdrop');

        // Check & Apply Saved Desktop State
        function applyUserSidebarState() {
            const isCollapsed = localStorage.getItem('user_sidebar_collapsed') === 'true';
            if (window.innerWidth >= 768) {
                backdrop?.classList.add('hidden');
                if (isCollapsed) {
                    sidebar?.classList.remove('translate-x-0');
                    sidebar?.classList.add('-translate-x-full');
                    userMainContent?.classList.remove('md:ml-64');
                    userMainContent?.classList.add('md:ml-0');
                } else {
                    sidebar?.classList.remove('-translate-x-full');
                    sidebar?.classList.add('translate-x-0');
                    userMainContent?.classList.remove('md:ml-0');
                    userMainContent?.classList.add('md:ml-64');
                }
            } else {
                sidebar?.classList.remove('translate-x-0');
                sidebar?.classList.add('-translate-x-full');
                userMainContent?.classList.remove('md:ml-64');
                userMainContent?.classList.add('md:ml-0');
            }
        }

        // Run immediately
        applyUserSidebarState();

        // Desktop Toggle Action
        userDesktopToggle?.addEventListener('click', () => {
            const isCurrentlyOpen = sidebar?.classList.contains('translate-x-0');
            if (isCurrentlyOpen) {
                sidebar?.classList.remove('translate-x-0');
                sidebar?.classList.add('-translate-x-full');
                userMainContent?.classList.remove('md:ml-64');
                userMainContent?.classList.add('md:ml-0');
                localStorage.setItem('user_sidebar_collapsed', 'true');
            } else {
                sidebar?.classList.remove('-translate-x-full');
                sidebar?.classList.add('translate-x-0');
                userMainContent?.classList.remove('md:ml-0');
                userMainContent?.classList.add('md:ml-64');
                localStorage.setItem('user_sidebar_collapsed', 'false');
            }
        });

        // Mobile Sidebar Drawer Toggle
        function toggleUserMobileSidebar() {
            const isDrawerOpen = sidebar?.classList.contains('translate-x-0');
            if (isDrawerOpen) {
                sidebar?.classList.remove('translate-x-0');
                sidebar?.classList.add('-translate-x-full');
                backdrop?.classList.add('hidden');
            } else {
                sidebar?.classList.remove('-translate-x-full');
                sidebar?.classList.add('translate-x-0');
                backdrop?.classList.remove('hidden');
            }
        }

        mobileToggle?.addEventListener('click', toggleUserMobileSidebar);
        backdrop?.addEventListener('click', toggleUserMobileSidebar);

        // Handle Window Resize
        window.addEventListener('resize', applyUserSidebarState);

        // Logout Handler (Form POST with CSRF)
        document.getElementById('logoutBtn')?.addEventListener('click', (e) => {
            e.preventDefault();
            document.getElementById('logoutForm')?.submit();
        });

        // Global Helper to Start Chat with Prompt
        function startChatWithPrompt(promptText) {
            sessionStorage.setItem('pending_prompt', promptText);
            window.location.href = '/chat';
        }

        /**
         * AJAX Helper — mengirim request dengan CSRF token (session-based auth).
         * Menggantikan pola Bearer token + localStorage.
         */
        async function ajaxRequest(url, options = {}) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
            const defaultHeaders = {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            };

            if (!(options.body instanceof FormData)) {
                defaultHeaders['Content-Type'] = 'application/json';
            }

            const response = await fetch(url, {
                credentials: 'same-origin',
                ...options,
                headers: {
                    ...defaultHeaders,
                    ...(options.headers || {}),
                },
            });

            // Jika 401/419, redirect ke login
            if (response.status === 401 || response.status === 419) {
                window.location.href = '/login';
                return null;
            }

            return response;
        }
    </script>
    @stack('scripts')
</body>

</html>