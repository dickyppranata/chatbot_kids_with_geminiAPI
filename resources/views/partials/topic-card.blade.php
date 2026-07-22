<!-- Topic Card Component (Partials) -->
@props([
    'topicId' => null,
    'title' => 'Topik Belajar',
    'emoji' => '📖',
    'description' => 'Deskripsi materi pelajaran.',
    'accent' => 'from-orange-500 to-amber-500',
    'badgeColor' => 'bg-amber-100 text-amber-700',
    'prompts' => [],
])

<div class="group relative bg-white/80 backdrop-blur-md border border-slate-200/60 rounded-3xl p-6 shadow-sm hover:shadow-xl hover:shadow-terracotta/5 hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between overflow-hidden">
    <!-- Top Accent Bar -->
    <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r {{ $accent }} rounded-t-3xl"></div>

    <div>
        <div class="flex items-center justify-between mb-4">
            <div class="w-14 h-14 bg-slate-100 rounded-2xl flex items-center justify-center text-3xl shadow-inner group-hover:scale-110 transition-transform">
                <span>{{ $emoji }}</span>
            </div>
            <span class="text-xs font-outfit font-bold px-3 py-1 rounded-full {{ $badgeColor }}">
                SD / SMP
            </span>
        </div>

        <h3 class="font-outfit font-extrabold text-xl text-slate-900 mb-2 group-hover:text-terracotta transition-colors">
            {{ $title }}
        </h3>
        <p class="text-xs md:text-sm text-slate-600 leading-relaxed font-medium mb-4">
            {{ $description }}
        </p>

        <!-- Sample Questions Chips -->
        @if(count($prompts) > 0)
            <div class="space-y-1.5 mb-6">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Contoh Pertanyaan:</p>
                <div class="flex flex-wrap gap-1.5">
                    @foreach($prompts as $prompt)
                        <a
                            href="/chat?{{ $topicId ? 'topic_id='.$topicId.'&' : '' }}prompt={{ urlencode($prompt) }}"
                            class="text-left text-xs font-semibold px-3 py-1.5 rounded-xl bg-slate-100/90 text-slate-700 border border-slate-200/60 hover:bg-terracotta/10 hover:border-terracotta/40 hover:text-terracotta transition-all truncate max-w-full no-underline"
                        >
                            💬 "{{ $prompt }}"
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <!-- Action Button -->
    <a
        href="/chat{{ $topicId ? '?topic_id='.$topicId : '' }}"
        class="w-full py-3 rounded-2xl bg-slate-100 hover:bg-terracotta hover:text-white text-slate-700 font-outfit font-bold text-xs shadow-sm hover:shadow-md transition-all duration-200 flex items-center justify-center gap-2 no-underline"
    >
        <span>Mulai Belajar Topik Ini</span>
        <i class="bi bi-arrow-right-short text-lg"></i>
    </a>
</div>
