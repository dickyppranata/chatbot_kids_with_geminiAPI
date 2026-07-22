<!-- Sidebar Component (Partials) -->
<aside id="appSidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full md:translate-x-0 bg-white/80 backdrop-blur-md border-r border-slate-200/60 flex flex-col justify-between p-4">
    <div>
        <!-- Logo Header -->
        <div class="flex items-center gap-3 px-2 py-3 mb-6 border-b border-slate-100">
            <div class="w-10 h-10 bg-gradient-to-br from-terracotta to-amber-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-terracotta/20">
                <i class="bi bi-robot text-xl"></i>
            </div>
            <div>
                <h1 class="font-outfit font-extrabold text-lg tracking-tight text-slate-900 leading-none">
                    AI Buddy
                </h1>
                <span class="text-[11px] font-semibold text-terracotta">Tutor Belajar Pintar</span>
            </div>
        </div>

        <!-- Action Button: + Chat Baru -->
        <div class="mb-6 px-1">
            <a href="/chat" class="w-full py-3.5 px-5 rounded-2xl bg-gradient-to-r from-terracotta to-orange-600 hover:from-terracotta-hover hover:to-orange-700 text-white font-outfit font-bold text-sm shadow-lg shadow-terracotta/25 hover:shadow-xl hover:shadow-terracotta/35 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 flex items-center justify-center gap-2.5 no-underline">
                <i class="bi bi-plus-circle-fill text-lg"></i>
                <span>+ Chat Baru</span>
            </a>
        </div>

        <!-- Main Navigation Links -->
        <nav class="space-y-1.5 font-outfit font-semibold text-sm">
            <a href="/dashboard" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 {{ request()->is('dashboard') ? 'bg-terracotta/10 text-terracotta font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                <i class="bi bi-grid-1x2-fill text-lg"></i>
                <span>Dashboard</span>
            </a>

            <a href="/chat" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 {{ request()->is('chat*') ? 'bg-terracotta/10 text-terracotta font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                <i class="bi bi-chat-dots-fill text-lg"></i>
                <span>Tutor Chat</span>
            </a>

            <a href="/history" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 {{ request()->is('history*') ? 'bg-terracotta/10 text-terracotta font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                <i class="bi bi-clock-history text-lg"></i>
                <span>Riwayat Belajar</span>
            </a>

            <a href="/favorites" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 {{ request()->is('favorites*') ? 'bg-terracotta/10 text-terracotta font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                <i class="bi bi-star-fill text-lg"></i>
                <span>Jawaban Favorit</span>
            </a>
        </nav>
    </div>

    <!-- Bottom User Profile & Settings -->
    <div class="pt-4 border-t border-slate-100 space-y-2">
        <!-- User Info Badge -->
        <div class="flex items-center justify-between p-2.5 rounded-2xl bg-slate-100/70 border border-slate-200/50">
            <div class="flex items-center gap-2.5 overflow-hidden">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-r from-amber-400 to-terracotta flex items-center justify-center text-white font-bold text-sm shrink-0 shadow-sm" id="sidebarUserAvatar">
                    🧒
                </div>
                <div class="truncate">
                    <p class="font-outfit font-bold text-xs text-slate-900 truncate" id="sidebarUserName">User</p>
                    <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full bg-amber-100 text-amber-700 uppercase tracking-wider" id="sidebarUserRole">anak</span>
                </div>
            </div>

            <!-- Logout Button -->
            <button id="logoutBtn" title="Keluar" class="w-8 h-8 rounded-xl text-slate-400 hover:text-red-500 hover:bg-red-50 flex items-center justify-center transition-colors">
                <i class="bi bi-box-arrow-right text-base"></i>
            </button>
        </div>

        <a href="/" class="block text-center text-xs font-semibold text-slate-400 hover:text-terracotta transition-colors py-1">
            <i class="bi bi-house-door-fill mr-1"></i> Beranda Utama
        </a>
    </div>
</aside>
