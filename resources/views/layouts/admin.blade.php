<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel - AI Buddy')</title>

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
</head>

<body class="bg-slate-100 text-slate-900 min-h-screen font-sans antialiased">

    <div class="min-h-screen flex">
        <!-- Modular Admin Sidebar -->
        @include('partials.admin-sidebar')

        <!-- Mobile Sidebar Backdrop Overlay -->
        <div id="adminSidebarBackdrop" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-30 hidden md:hidden">
        </div>

        <!-- Main Content Area -->
        <div id="adminMainContent" class="flex-1 md:ml-64 flex flex-col min-w-0 min-h-screen transition-all duration-300">

            <!-- Admin Top Header Bar -->
            <header
                class="sticky top-0 z-30 bg-white/90 backdrop-blur-md border-b border-slate-200/80 px-4 md:px-8 py-4 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <!-- Mobile Sidebar Toggle -->
                    <button id="adminMobileToggle"
                        class="md:hidden w-10 h-10 rounded-2xl bg-slate-100 text-slate-700 flex items-center justify-center hover:bg-slate-200 transition-colors" title="Buka Menu Sidebar">
                        <i class="bi bi-list text-xl"></i>
                    </button>
                    <!-- Desktop Sidebar Toggle Button -->
                    <button id="adminDesktopToggle"
                        class="hidden md:flex w-10 h-10 rounded-2xl bg-slate-100 text-slate-700 hover:bg-terracotta hover:text-white flex items-center justify-center transition-all shadow-sm" title="Sembunyikan / Tampilkan Sidebar">
                        <i class="bi bi-layout-sidebar-inset text-lg"></i>
                    </button>
                    <div>
                        <h2
                            class="font-outfit font-extrabold text-lg md:text-xl text-slate-900 flex items-center gap-2">
                            @yield('page_heading', 'Dashboard Administrator')
                        </h2>
                        <p class="text-xs text-slate-500 font-medium hidden sm:block">
                            @yield('page_subheading', 'Kelola platform edukasi chatbot AI Buddy')
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <!-- Environment Status Badge -->
                    <div
                        class="px-3 py-1.5 rounded-full bg-slate-900 text-white text-xs font-bold flex items-center gap-1.5 shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>System Live</span>
                    </div>
                </div>
            </header>

            <!-- Main Page Content -->
            <main class="flex-1 p-4 md:p-8">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Admin Sidebar Toggle & Persistence Script -->
    <script>
        const adminSidebar = document.getElementById('adminSidebar');
        const adminMainContent = document.getElementById('adminMainContent');
        const adminMobileToggle = document.getElementById('adminMobileToggle');
        const adminDesktopToggle = document.getElementById('adminDesktopToggle');
        const adminBackdrop = document.getElementById('adminSidebarBackdrop');

        // Check & Apply Saved Desktop State
        function applyAdminSidebarState() {
            const isCollapsed = localStorage.getItem('admin_sidebar_collapsed') === 'true';
            if (window.innerWidth >= 768) {
                adminBackdrop?.classList.add('hidden');
                if (isCollapsed) {
                    adminSidebar?.classList.remove('translate-x-0');
                    adminSidebar?.classList.add('-translate-x-full');
                    adminMainContent?.classList.remove('md:ml-64');
                    adminMainContent?.classList.add('md:ml-0');
                } else {
                    adminSidebar?.classList.remove('-translate-x-full');
                    adminSidebar?.classList.add('translate-x-0');
                    adminMainContent?.classList.remove('md:ml-0');
                    adminMainContent?.classList.add('md:ml-64');
                }
            } else {
                adminSidebar?.classList.remove('translate-x-0');
                adminSidebar?.classList.add('-translate-x-full');
                adminMainContent?.classList.remove('md:ml-64');
                adminMainContent?.classList.add('md:ml-0');
            }
        }

        // Run immediately to avoid flicker
        applyAdminSidebarState();

        // Toggle Desktop State
        adminDesktopToggle?.addEventListener('click', () => {
            const isCurrentlyOpen = adminSidebar?.classList.contains('translate-x-0');
            if (isCurrentlyOpen) {
                adminSidebar?.classList.remove('translate-x-0');
                adminSidebar?.classList.add('-translate-x-full');
                adminMainContent?.classList.remove('md:ml-64');
                adminMainContent?.classList.add('md:ml-0');
                localStorage.setItem('admin_sidebar_collapsed', 'true');
            } else {
                adminSidebar?.classList.remove('-translate-x-full');
                adminSidebar?.classList.add('translate-x-0');
                adminMainContent?.classList.remove('md:ml-0');
                adminMainContent?.classList.add('md:ml-64');
                localStorage.setItem('admin_sidebar_collapsed', 'false');
            }
        });

        // Mobile Drawer Handlers
        function toggleAdminMobileSidebar() {
            const isDrawerOpen = adminSidebar?.classList.contains('translate-x-0');
            if (isDrawerOpen) {
                adminSidebar?.classList.remove('translate-x-0');
                adminSidebar?.classList.add('-translate-x-full');
                adminBackdrop?.classList.add('hidden');
            } else {
                adminSidebar?.classList.remove('-translate-x-full');
                adminSidebar?.classList.add('translate-x-0');
                adminBackdrop?.classList.remove('hidden');
            }
        }

        adminMobileToggle?.addEventListener('click', toggleAdminMobileSidebar);
        adminBackdrop?.addEventListener('click', toggleAdminMobileSidebar);

        // Handle Window Resize
        window.addEventListener('resize', applyAdminSidebarState);
    </script>
    @stack('scripts')
</body>

</html>