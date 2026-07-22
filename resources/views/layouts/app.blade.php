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
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Laravel Vite Asset Compiler -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-15px) rotate(2deg); }
        }
        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-float-delay { animation: float 6s ease-in-out 2s infinite; }
    </style>
</head>
<body class="bg-cream-bg text-slate-900 min-h-screen font-sans antialiased">

    <!-- Background Ambient Glowing Orbs -->
    <div class="fixed top-0 left-0 w-96 h-96 bg-terracotta/10 rounded-full filter blur-[100px] -z-10 animate-float pointer-events-none"></div>
    <div class="fixed bottom-0 right-0 w-[450px] h-[450px] bg-amber-500/10 rounded-full filter blur-[120px] -z-10 animate-float-delay pointer-events-none"></div>

    <div class="min-h-screen flex">
        <!-- Modular Component: Sidebar -->
        @include('partials.sidebar')

        <!-- Mobile Sidebar Backdrop Overlay -->
        <div id="sidebarBackdrop" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-30 hidden md:hidden"></div>

        <!-- Main Content Area -->
        <div class="flex-1 md:ml-64 flex flex-col min-w-0 min-h-screen">
            <!-- Modular Component: Header Top Bar -->
            @include('partials.header')

            <!-- Main Page Content -->
            <main class="flex-1 p-4 md:p-8">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Global App JavaScript -->
    <script>
        // Force Light Theme (Remove Dark Theme)
        document.documentElement.classList.remove('dark');
        localStorage.removeItem('theme');

        // Mobile Sidebar Drawer Toggle
        const mobileToggle = document.getElementById('mobileSidebarToggle');
        const sidebar = document.getElementById('appSidebar');
        const backdrop = document.getElementById('sidebarBackdrop');

        function toggleSidebar() {
            sidebar?.classList.toggle('-translate-x-full');
            backdrop?.classList.toggle('hidden');
        }

        mobileToggle?.addEventListener('click', toggleSidebar);
        backdrop?.addEventListener('click', toggleSidebar);

        // User Authentication Sync
        async function fetchUserProfile() {
            const token = localStorage.getItem('access_token');
            if (!token) return;

            try {
                const response = await fetch('/api/auth/me', {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }
                });
                const result = await response.json();

                if (response.ok && result.status === 'success') {
                    const user = result.data;
                    localStorage.setItem('user', JSON.stringify(user));

                    // Update UI elements if present
                    const nameEl = document.getElementById('sidebarUserName');
                    const headerGreeting = document.getElementById('headerGreetingName');
                    const userRoleEl = document.getElementById('sidebarUserRole');

                    if (nameEl) nameEl.textContent = user.name;
                    if (headerGreeting) headerGreeting.textContent = user.name;
                    if (userRoleEl) userRoleEl.textContent = user.role || 'anak';
                }
            } catch (e) {
                console.error('Failed to fetch user profile:', e);
            }
        }
        document.addEventListener('DOMContentLoaded', fetchUserProfile);

        // Logout Handler
        document.getElementById('logoutBtn')?.addEventListener('click', async () => {
            const token = localStorage.getItem('access_token');
            if (token) {
                try {
                    await fetch('/api/auth/logout', {
                        method: 'POST',
                        headers: {
                            'Authorization': `Bearer ${token}`,
                            'Accept': 'application/json'
                        }
                    });
                } catch (e) {}
            }
            localStorage.removeItem('access_token');
            localStorage.removeItem('user');
            window.location.href = '/login';
        });

        // Global Helper to Start Chat with Prompt
        function startChatWithPrompt(promptText) {
            sessionStorage.setItem('pending_prompt', promptText);
            window.location.href = '/chat';
        }
    </script>
    @stack('scripts')
</body>
</html>
