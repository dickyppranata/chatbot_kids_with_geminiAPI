<!-- Header Component (Partials) -->
<header
    class="sticky top-0 z-30 bg-white/80 backdrop-blur-md border-b border-slate-200/60 px-4 md:px-8 py-3.5 flex items-center justify-between transition-colors">
    <!-- Left: Mobile Sidebar Toggle & Page Title -->
    <div class="flex items-center gap-3">
        <!-- Mobile menu toggle -->
        <button id="mobileSidebarToggle"
            class="md:hidden w-10 h-10 rounded-2xl bg-slate-100 text-slate-700 flex items-center justify-center hover:bg-slate-200 transition-colors">
            <i class="bi bi-list text-xl"></i>
        </button>

        <div>
            <h2 class="font-outfit font-extrabold text-lg md:text-xl text-slate-900 flex items-center gap-2">
                <span>Halo, <span class="text-terracotta">{{ Auth::user()->name ?? 'Teman' }}</span> 👋</span>
            </h2>
            <p class="text-xs text-slate-500 font-medium hidden sm:block">
                Mari eksplorasi ilmu baru bersama Kakak AI hari ini!
            </p>
        </div>
    </div>

    <!-- Right: Search & User Status -->
    <div class="flex items-center gap-3">
        <!-- Search Quick Input -->
        <div class="relative hidden lg:block">
            <i class="bi bi-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
            <input type="text" placeholder="Cari topik atau materi..."
                class="w-60 pl-9 pr-4 py-2 bg-slate-100/80 border border-slate-200/70 rounded-full text-xs font-medium text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-terracotta transition-colors">
        </div>

        <!-- Status Indicator -->
        <div
            class="hidden sm:flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-50 border border-emerald-200/60 text-emerald-700 text-xs font-bold">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            <span>AI Tutor Aktif</span>
        </div>
    </div>
</header>