@extends('layouts.app')

@section('title', 'Dashboard User - AI Buddy KawanBelajar')

@section('content')
<div class="space-y-8 animate-fade-in">

    <!-- 1. Hero Banner Greeting -->
    <div class="relative bg-gradient-to-r from-terracotta via-orange-600 to-amber-500 rounded-3xl p-6 md:p-8 text-white shadow-xl shadow-terracotta/20 overflow-hidden">
        <!-- Ambient decorative shapes -->
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-white/10 rounded-full filter blur-2xl pointer-events-none"></div>
        <div class="absolute right-40 -top-10 w-40 h-40 bg-amber-300/20 rounded-full filter blur-xl pointer-events-none"></div>

        <div class="relative z-10 grid md:grid-cols-3 gap-6 items-center">
            <div class="md:col-span-2 space-y-3">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/20 backdrop-blur-md text-xs font-bold uppercase tracking-wider text-amber-100 border border-white/30">
                    ✨ Sahabat Belajar Pintar
                </span>
                <h1 class="font-outfit font-extrabold text-2xl md:text-4xl leading-tight">
                    Selamat Datang, <span class="underline decoration-amber-300 decoration-wavy underline-offset-4">{{ Auth::user()->name }}!</span>
                </h1>
                <p class="text-xs md:text-sm text-amber-50 font-medium leading-relaxed max-w-xl">
                    Tanyakan apa saja seputar Matematika, Sains, Bahasa, atau Pengetahuan Umum. Kakak AI siap menjelaskan dengan contoh yang seru dan mudah dipahami!
                </p>
                <div class="pt-2 flex flex-wrap gap-3">
                    <a href="/chat" class="px-5 py-3 rounded-2xl bg-white text-terracotta hover:bg-amber-50 font-outfit font-extrabold text-sm shadow-md hover:shadow-lg transition-all no-underline inline-flex items-center gap-2">
                        <i class="bi bi-chat-text-fill text-lg"></i>
                        <span>Mulai Tanya Kakak AI</span>
                    </a>
                    <a href="#topics" class="px-5 py-3 rounded-2xl bg-white/15 hover:bg-white/25 text-white font-outfit font-bold text-sm backdrop-blur-md border border-white/30 transition-all no-underline inline-flex items-center gap-2">
                        <i class="bi bi-compass-fill"></i>
                        <span>Jelajahi Topik</span>
                    </a>
                </div>
            </div>

            <!-- Avatar Illustration -->
            <div class="hidden md:flex justify-end">
                <div class="w-36 h-36 bg-white/20 backdrop-blur-md border-2 border-white/40 rounded-full flex items-center justify-center text-6xl shadow-2xl animate-float">
                    🤖
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Stat Cards Grid (Server-Side Data from $stats) -->
    @php
        $chatBadge = 'Penjelajah Muda 🧒';
        if ($stats['total_chats'] >= 10) $chatBadge = 'Cendekia Muda 🎓';
        elseif ($stats['total_chats'] >= 5) $chatBadge = 'Siswa Aktif 🌟';
    @endphp

    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
        @include('partials.stat-card', [
            'title' => 'Total Percakapan',
            'value' => $stats['total_chats'] . ' Sesi',
            'icon' => 'bi-chat-dots-fill',
            'gradient' => 'from-terracotta to-orange-500',
            'badge' => 'Sesi Aktif'
        ])

        @include('partials.stat-card', [
            'title' => 'Topik Pelajaran',
            'value' => $stats['total_topics'] . ' Topik',
            'icon' => 'bi-journal-bookmark-fill',
            'gradient' => 'from-amber-500 to-yellow-400',
            'badge' => 'SD / SMP'
        ])

        @include('partials.stat-card', [
            'title' => 'Jawaban Disimpan',
            'value' => $stats['total_favorites'] . ' Favorit',
            'icon' => 'bi-star-fill',
            'gradient' => 'from-cyan-500 to-blue-500',
            'badge' => 'Catatan Penting'
        ])

        @include('partials.stat-card', [
            'title' => 'Lencana Belajar',
            'value' => $chatBadge,
            'icon' => 'bi-award-fill',
            'gradient' => 'from-emerald-500 to-teal-400',
            'badge' => $stats['total_chats'] >= 10 ? 'Level 3' : ($stats['total_chats'] >= 5 ? 'Level 2' : 'Level 1')
        ])
    </div>

    <!-- 3. Topic Navigation Cards (Server-Side Rendered from $topics) -->
    @php
        $topicMeta = [
            'matematika'        => ['emoji' => '🍕', 'accent' => 'from-orange-500 to-amber-500', 'badge' => 'bg-amber-100 text-amber-700'],
            'sains-ipa'         => ['emoji' => '🚀', 'accent' => 'from-cyan-500 to-blue-500', 'badge' => 'bg-cyan-100 text-cyan-700'],
            'bahasa-indonesia'  => ['emoji' => '📚', 'accent' => 'from-emerald-500 to-teal-400', 'badge' => 'bg-emerald-100 text-emerald-700'],
            'pengetahuan-umum'  => ['emoji' => '🌐', 'accent' => 'from-violet-500 to-purple-500', 'badge' => 'bg-violet-100 text-violet-700'],
        ];
    @endphp

    <section id="topics" class="space-y-4 pt-2">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-outfit font-extrabold text-xl md:text-2xl text-slate-900 flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-terracotta inline-block"></span>
                    Pilih Topik Belajar Favoritmu
                </h2>
                <p class="text-xs md:text-sm text-slate-500 font-medium">
                    Klik salah satu topik atau pertanyaan di bawah untuk mulai berdiskusi bersama AI Tutor.
                </p>
            </div>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($topics as $topic)
                @php
                    $meta = $topicMeta[$topic->slug] ?? ['emoji' => '📖', 'accent' => 'from-slate-500 to-slate-400', 'badge' => 'bg-slate-100 text-slate-700'];
                @endphp
                <div class="group relative bg-white/80 backdrop-blur-md border border-slate-200/60 rounded-3xl p-6 shadow-sm hover:shadow-xl hover:shadow-terracotta/5 hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between overflow-hidden">
                    <!-- Top Accent Bar -->
                    <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r {{ $meta['accent'] }} rounded-t-3xl"></div>

                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-14 h-14 bg-slate-100 rounded-2xl flex items-center justify-center text-3xl shadow-inner group-hover:scale-110 transition-transform">
                                <span>{{ $meta['emoji'] }}</span>
                            </div>
                            <span class="text-xs font-outfit font-bold px-3 py-1 rounded-full {{ $meta['badge'] }}">
                                SD / SMP
                            </span>
                        </div>

                        <h3 class="font-outfit font-extrabold text-xl text-slate-900 mb-2 group-hover:text-terracotta transition-colors">
                            {{ $topic->name }}
                        </h3>
                        <p class="text-xs md:text-sm text-slate-600 leading-relaxed font-medium mb-4">
                            {{ $topic->description ?? 'Materi pelajaran menarik.' }}
                        </p>

                        <!-- Sample Questions Chips -->
                        @if($topic->examplePrompts->count() > 0)
                            <div class="space-y-1.5 mb-6">
                                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Contoh Pertanyaan:</p>
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach($topic->examplePrompts->take(2) as $ep)
                                        <a
                                            href="/chat?topic_id={{ $topic->id }}&prompt={{ urlencode($ep->question_text) }}"
                                            class="text-left text-xs font-semibold px-3 py-1.5 rounded-xl bg-slate-100/90 text-slate-700 border border-slate-200/60 hover:bg-terracotta/10 hover:border-terracotta/40 hover:text-terracotta transition-all truncate max-w-full no-underline"
                                        >
                                            💬 "{{ Str::limit($ep->question_text, 40) }}"
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Action Button -->
                    <a
                        href="/chat?topic_id={{ $topic->id }}"
                        class="w-full py-3 rounded-2xl bg-slate-100 hover:bg-terracotta hover:text-white text-slate-700 font-outfit font-bold text-xs shadow-sm hover:shadow-md transition-all duration-200 flex items-center justify-center gap-2 no-underline"
                    >
                        <span>Mulai Belajar Topik Ini</span>
                        <i class="bi bi-arrow-right-short text-lg"></i>
                    </a>
                </div>
            @endforeach
        </div>
    </section>

    <!-- 4. Bottom Grid: Recent Chats & Quick Prompts -->
    <div class="grid lg:grid-cols-3 gap-6 pt-2">
        <!-- Recent Chats (2 Cols) -->
        <div class="lg:col-span-2">
            @include('partials.recent-chats')
        </div>

        <!-- Quick Prompts Card -->
        <div class="bg-gradient-to-br from-amber-500/10 via-terracotta/5 to-transparent border border-amber-200/60 rounded-3xl p-6 flex flex-col justify-between">
            <div class="space-y-4">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-amber-400 text-white flex items-center justify-center font-bold shadow-md">
                        <i class="bi bi-lightning-charge-fill text-lg"></i>
                    </div>
                    <div>
                        <h3 class="font-outfit font-extrabold text-base text-slate-900 leading-tight">
                            Ide Pertanyaan Hari Ini
                        </h3>
                        <p class="text-xs text-slate-500 font-medium">Klik untuk langsung bertanya</p>
                    </div>
                </div>

                <div class="space-y-2">
                    <a href="/chat?prompt={{ urlencode('Mengapa langit berwarna biru saat siang hari?') }}" class="w-full text-left p-3 rounded-2xl bg-white/90 border border-slate-200/60 text-xs font-semibold text-slate-800 hover:border-terracotta hover:text-terracotta transition-all flex items-center justify-between group shadow-sm no-underline">
                        <span>🌈 Mengapa langit berwarna biru?</span>
                        <i class="bi bi-chevron-right text-slate-400 group-hover:translate-x-1 transition-transform"></i>
                    </a>

                    <a href="/chat?prompt={{ urlencode('Bagaimana cara kerja magnet menempel pada besi?') }}" class="w-full text-left p-3 rounded-2xl bg-white/90 border border-slate-200/60 text-xs font-semibold text-slate-800 hover:border-terracotta hover:text-terracotta transition-all flex items-center justify-between group shadow-sm no-underline">
                        <span>🧲 Bagaimana cara kerja magnet?</span>
                        <i class="bi bi-chevron-right text-slate-400 group-hover:translate-x-1 transition-transform"></i>
                    </a>

                    <a href="/chat?prompt={{ urlencode('Bisa tolong beri latihan soal perkalian 7 dan 8?') }}" class="w-full text-left p-3 rounded-2xl bg-white/90 border border-slate-200/60 text-xs font-semibold text-slate-800 hover:border-terracotta hover:text-terracotta transition-all flex items-center justify-between group shadow-sm no-underline">
                        <span>✏️ Latihan soal perkalian 7 & 8</span>
                        <i class="bi bi-chevron-right text-slate-400 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>

            <div class="pt-6 border-t border-amber-200/40 text-center">
                <p class="text-[11px] text-slate-500 font-medium">
                    Ingin belajar topik lain? <a href="/chat" class="font-bold text-terracotta hover:underline">Tulis pertanyaan bebas di Chat Tutor</a>
                </p>
            </div>
        </div>
    </div>

</div>
@endsection
