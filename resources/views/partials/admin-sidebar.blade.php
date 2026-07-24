<!-- Admin Sidebar Component (Partials) -->
<aside id="adminSidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full md:translate-x-0 bg-slate-900 text-white flex flex-col justify-between p-4 shadow-2xl">
    <div class="flex flex-col h-[calc(100vh-80px)]">
        
        <!-- Logo & Admin Branding Header -->
        <div class="flex items-center gap-3 px-2 py-3 mb-5 border-b border-slate-800 shrink-0">
            <div class="w-10 h-10 bg-gradient-to-br from-terracotta to-amber-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-terracotta/30">
                <i class="bi bi-shield-lock-fill text-xl"></i>
            </div>
            <div class="truncate">
                <div class="flex items-center gap-1.5">
                    <h1 class="font-outfit font-extrabold text-lg tracking-tight text-white leading-none">
                        AI Buddy
                    </h1>
                    <span class="px-1.5 py-0.5 rounded text-[9px] font-black uppercase tracking-wider bg-terracotta text-white">
                        ADMIN
                    </span>
                </div>
                <span class="text-[11px] font-medium text-slate-400">Control Panel System</span>
            </div>
        </div>

        <!-- Admin Navigation Links (Full Menu Architecture) -->
        <nav class="space-y-1.5 font-outfit font-semibold text-sm overflow-y-auto pr-1 flex-1 scrollbar-none">
            
            <!-- 1. Dashboard -->
            <a href="/admin/dashboard" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 {{ request()->is('admin/dashboard*') ? 'bg-terracotta text-white shadow-lg shadow-terracotta/30 font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <i class="bi bi-grid-1x2-fill text-lg"></i>
                <span>Dashboard</span>
            </a>

            <div class="pt-3 pb-1 px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                Kelola Data Master
            </div>

            <!-- 2. Manajemen Pengguna -->
            <a href="/admin/users" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 {{ request()->is('admin/users*') ? 'bg-terracotta text-white shadow-lg shadow-terracotta/30 font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <i class="bi bi-people-fill text-lg"></i>
                <span>Manajemen Pengguna</span>
            </a>

            <!-- 3. Manajemen Topik -->
            <a href="/admin/topics" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 {{ request()->is('admin/topics*') ? 'bg-terracotta text-white shadow-lg shadow-terracotta/30 font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <i class="bi bi-journal-bookmark-fill text-lg"></i>
                <span>Manajemen Topik</span>
            </a>

            <!-- 4. Manajemen Prompt -->
            <a href="/admin/prompts" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 {{ request()->is('admin/prompts*') ? 'bg-terracotta text-white shadow-lg shadow-terracotta/30 font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <i class="bi bi-cpu-fill text-lg"></i>
                <span>Manajemen Prompt</span>
            </a>

            <!-- 5. Manajemen Example Prompt -->
            <a href="/admin/example-prompts" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 {{ request()->is('admin/example-prompts*') ? 'bg-terracotta text-white shadow-lg shadow-terracotta/30 font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <i class="bi bi-chat-quote-fill text-lg"></i>
                <span>Example Prompt</span>
            </a>

            <div class="pt-3 pb-1 px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                Monitoring & Akun
            </div>

            <!-- 6. Riwayat Percakapan -->
            <a href="/admin/chat-history" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 {{ request()->is('admin/chat-history*') ? 'bg-terracotta text-white shadow-lg shadow-terracotta/30 font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <i class="bi bi-clock-history text-lg"></i>
                <span>Riwayat Percakapan</span>
            </a>

            <!-- 7. Statistik -->
            <a href="/admin/statistics" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 {{ request()->is('admin/statistics*') ? 'bg-terracotta text-white shadow-lg shadow-terracotta/30 font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <i class="bi bi-bar-chart-line-fill text-lg"></i>
                <span>Statistik Analitik</span>
            </a>

            <!-- 8. Profil Admin -->
            <a href="/admin/profile" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 {{ request()->is('admin/profile*') ? 'bg-terracotta text-white shadow-lg shadow-terracotta/30 font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <i class="bi bi-person-badge-fill text-lg"></i>
                <span>Profil Admin</span>
            </a>
        </nav>
    </div>

    <!-- Bottom User Info & Switch to User View -->
    <div class="pt-4 border-t border-slate-800 space-y-2 shrink-0">
        <div class="flex items-center justify-between p-2.5 rounded-2xl bg-slate-800/80 border border-slate-700/50">
            <div class="flex items-center gap-2.5 overflow-hidden">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-r from-terracotta to-amber-500 flex items-center justify-center text-white font-bold text-sm shrink-0 shadow-sm">
                    👨‍🏫
                </div>
                <div class="truncate">
                    <p class="font-outfit font-bold text-xs text-white truncate">{{ Auth::user()->name ?? 'Administrator' }}</p>
                    <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full bg-red-900/60 text-red-300 uppercase tracking-wider">ADMIN</span>
                </div>
            </div>

            <!-- Logout Button -->
            <button id="adminLogoutBtn" title="Keluar" class="w-8 h-8 rounded-xl text-slate-400 hover:text-red-400 hover:bg-slate-700 flex items-center justify-center transition-colors">
                <i class="bi bi-box-arrow-right text-base"></i>
            </button>
        </div>

        <form id="adminLogoutForm" action="/logout" method="POST" class="hidden">
            @csrf
        </form>

        <a href="/dashboard" class="block text-center text-xs font-semibold text-slate-400 hover:text-terracotta transition-colors py-1 no-underline">
            <i class="bi bi-arrow-left-right mr-1"></i> Tampilan Siswa
        </a>
    </div>
</aside>

<script>
    document.getElementById('adminLogoutBtn')?.addEventListener('click', (e) => {
        e.preventDefault();
        document.getElementById('adminLogoutForm')?.submit();
    });
</script>
