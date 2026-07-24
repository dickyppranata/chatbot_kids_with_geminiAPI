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
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">

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
        <div id="adminSidebarBackdrop" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-30 hidden md:hidden"></div>

        <!-- Main Content Area -->
        <div class="flex-1 md:ml-64 flex flex-col min-w-0 min-h-screen">
            
            <!-- Admin Top Header Bar -->
            <header class="sticky top-0 z-30 bg-white/90 backdrop-blur-md border-b border-slate-200/80 px-4 md:px-8 py-4 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <button id="adminMobileToggle" class="md:hidden w-10 h-10 rounded-2xl bg-slate-100 text-slate-700 flex items-center justify-center hover:bg-slate-200 transition-colors">
                        <i class="bi bi-list text-xl"></i>
                    </button>
                    <div>
                        <h2 class="font-outfit font-extrabold text-lg md:text-xl text-slate-900 flex items-center gap-2">
                            @yield('page_heading', 'Dashboard Administrator')
                        </h2>
                        <p class="text-xs text-slate-500 font-medium hidden sm:block">
                            @yield('page_subheading', 'Kelola platform edukasi chatbot AI Buddy')
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <!-- Environment Status Badge -->
                    <div class="px-3 py-1.5 rounded-full bg-slate-900 text-white text-xs font-bold flex items-center gap-1.5 shadow-sm">
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

    <!-- Admin Mobile Drawer Script -->
    <script>
        const adminMobileToggle = document.getElementById('adminMobileToggle');
        const adminSidebar = document.getElementById('adminSidebar');
        const adminBackdrop = document.getElementById('adminSidebarBackdrop');

        function toggleAdminSidebar() {
            adminSidebar?.classList.toggle('-translate-x-full');
            adminBackdrop?.classList.toggle('hidden');
        }

        adminMobileToggle?.addEventListener('click', toggleAdminSidebar);
        adminBackdrop?.addEventListener('click', toggleAdminSidebar);
    </script>
    @stack('scripts')
</body>
</html>
