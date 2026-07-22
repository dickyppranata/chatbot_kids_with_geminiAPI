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
                    Selamat Datang di <span class="underline decoration-amber-300 decoration-wavy underline-offset-4">AI Buddy!</span>
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

    <!-- 2. Stat Cards Grid (Modular Partial Component) -->
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
        @include('partials.stat-card', [
            'id' => 'statTotalChats',
            'title' => 'Total Percakapan',
            'value' => '0',
            'icon' => 'bi-chat-dots-fill',
            'gradient' => 'from-terracotta to-orange-500',
            'badge' => 'Sesi Aktif'
        ])

        @include('partials.stat-card', [
            'title' => 'Topik Pelajaran',
            'value' => '4 Topik',
            'icon' => 'bi-journal-bookmark-fill',
            'gradient' => 'from-amber-500 to-yellow-400',
            'badge' => 'SD / SMP'
        ])

        @include('partials.stat-card', [
            'title' => 'Jawaban Disimpan',
            'value' => '0 Favorit',
            'icon' => 'bi-star-fill',
            'gradient' => 'from-cyan-500 to-blue-500',
            'badge' => 'Catatan Penting'
        ])

        @include('partials.stat-card', [
            'title' => 'Lencana Belajar',
            'value' => 'Penjelajah Muda',
            'icon' => 'bi-award-fill',
            'gradient' => 'from-emerald-500 to-teal-400',
            'badge' => 'Level 1'
        ])
    </div>

    <!-- 3. Topic Navigation Cards Section -->
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
            <!-- Topic 1: Matematika Dasar -->
            @include('partials.topic-card', [
                'topicId' => 1,
                'title' => 'Matematika Dasar',
                'emoji' => '🍕',
                'description' => 'Pecahan, perkalian, bangun ruang, dan logika angka dengan contoh analogi sederhana.',
                'accent' => 'from-orange-500 to-amber-500',
                'badgeColor' => 'bg-amber-100 text-amber-700',
                'prompts' => [
                    'Apa itu pecahan 1/4?',
                    'Bagaimana cara menghitung luas persegi?'
                ]
            ])

            <!-- Topic 2: Sains & Alam -->
            @include('partials.topic-card', [
                'topicId' => 2,
                'title' => 'Sains & Alam',
                'emoji' => '🚀',
                'description' => 'Menjelaskan fenomena alam seperti proses hujan, fotosintesis, tata surya, dan energi.',
                'accent' => 'from-cyan-500 to-blue-500',
                'badgeColor' => 'bg-cyan-100 text-cyan-700',
                'prompts' => [
                    'Mengapa air hujan rasanya tawar?',
                    'Bagaimana cara tanaman makan?'
                ]
            ])

            <!-- Topic 3: Bahasa Indonesia -->
            @include('partials.topic-card', [
                'topicId' => 3,
                'title' => 'Bahasa Indonesia',
                'emoji' => '📚',
                'description' => 'Kosakata baru, sinonim & antonim, tata bahasa, dan tips membuat karangan cerita seru.',
                'accent' => 'from-emerald-500 to-teal-400',
                'badgeColor' => 'bg-emerald-100 text-emerald-700',
                'prompts' => [
                    'Apa bedanya sinonim dan antonim?',
                    'Bantu aku buat puisi tentang alam'
                ]
            ])

            <!-- Topic 4: Pengetahuan Umum -->
            @include('partials.topic-card', [
                'topicId' => 4,
                'title' => 'Pengetahuan Umum',
                'emoji' => '🌐',
                'description' => 'Fakta unik dunia, sejarah tokoh inspiratif, peta geografi, dan kebudayaan nusantara.',
                'accent' => 'from-violet-500 to-purple-500',
                'badgeColor' => 'bg-violet-100 text-violet-700',
                'prompts' => [
                    'Siapa penemu lampu bohlam?',
                    'Berapa jumlah provinsi di Indonesia?'
                ]
            ])
        </div>
    </section>

    <!-- 4. Bottom Grid: Recent Chats & Quick Quiz Prompts -->
    <div class="grid lg:grid-cols-3 gap-6 pt-2">
        <!-- Recent Chats Partial (2 Cols) -->
        <div class="lg:col-span-2">
            @include('partials.recent-chats')
        </div>

        <!-- Quick Prompts Card (1 Col) -->
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
                    <button onclick="startChatWithPrompt('Mengapa langit berwarna biru saat siang hari?')" class="w-full text-left p-3 rounded-2xl bg-white/90 border border-slate-200/60 text-xs font-semibold text-slate-800 hover:border-terracotta hover:text-terracotta transition-all flex items-center justify-between group shadow-sm">
                        <span>🌈 Mengapa langit berwarna biru?</span>
                        <i class="bi bi-chevron-right text-slate-400 group-hover:translate-x-1 transition-transform"></i>
                    </button>

                    <button onclick="startChatWithPrompt('Bagaimana cara kerja magnet menempel pada besi?')" class="w-full text-left p-3 rounded-2xl bg-white/90 border border-slate-200/60 text-xs font-semibold text-slate-800 hover:border-terracotta hover:text-terracotta transition-all flex items-center justify-between group shadow-sm">
                        <span>🧲 Bagaimana cara kerja magnet?</span>
                        <i class="bi bi-chevron-right text-slate-400 group-hover:translate-x-1 transition-transform"></i>
                    </button>

                    <button onclick="startChatWithPrompt('Bisa tolong beri latihan soal perkalian 7 dan 8?')" class="w-full text-left p-3 rounded-2xl bg-white/90 border border-slate-200/60 text-xs font-semibold text-slate-800 hover:border-terracotta hover:text-terracotta transition-all flex items-center justify-between group shadow-sm">
                        <span>✏️ Latihan soal perkalian 7 & 8</span>
                        <i class="bi bi-chevron-right text-slate-400 group-hover:translate-x-1 transition-transform"></i>
                    </button>
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

<script>
    function startChatWithPrompt(promptText) {
        window.location.href = `/chat?prompt=${encodeURIComponent(promptText)}`;
    }
</script>
@endsection
