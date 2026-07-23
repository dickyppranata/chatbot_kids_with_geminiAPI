<!-- Stat Card Component (Partials) -->
@props([
    'id' => '',
    'title' => 'Statistik',
    'value' => '0',
    'icon' => 'bi-bar-chart',
    'gradient' => 'from-terracotta to-amber-500',
    'badge' => null,
])

<div class="bg-white/80 backdrop-blur-md border border-slate-200/60 rounded-3xl p-5 shadow-sm hover:shadow-md transition-all duration-200 flex items-center gap-4">
    <div class="w-13 h-13 bg-gradient-to-br {{ $gradient }} rounded-2xl flex items-center justify-center text-white text-2xl shadow-md shrink-0">
        <i class="bi {{ $icon }}"></i>
    </div>
    <div class="flex-1 min-w-0">
        <p class="text-xs font-outfit font-bold text-slate-400 uppercase tracking-wider truncate">{{ $title }}</p>
        <h3 class="font-outfit font-extrabold text-2xl text-slate-900 leading-tight mt-0.5" id="{{ $id }}">
            {{ $value }}
        </h3>
        @if($badge)
            <span class="inline-block mt-1 text-[10px] font-bold px-2 py-0.5 rounded-full bg-slate-100 text-slate-600">
                {{ $badge }}
            </span>
        @endif
    </div>
</div>
