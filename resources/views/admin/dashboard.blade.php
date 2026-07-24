@extends('layouts.admin')

@section('title', 'Dashboard Admin - Control Panel AI Buddy')
@section('page_heading', 'Dashboard Administrator')
@section('page_subheading', 'Ringkasan performa sistem, statistik data master, dan aktivitas terkini')

@section('content')
<div class="space-y-8 animate-fade-in">

    <!-- 1. Hero Welcome Banner for Admin -->
    <div class="relative bg-gradient-to-r from-slate-900 via-slate-800 to-terracotta rounded-3xl p-6 md:p-8 text-white shadow-xl overflow-hidden">
        <div class="absolute right-0 top-0 w-96 h-96 bg-terracotta/20 rounded-full filter blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div class="space-y-2 max-w-2xl">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md text-xs font-bold uppercase tracking-wider text-amber-300 border border-white/20">
                    ⚡ Control Panel System
                </span>
                <h1 class="font-outfit font-extrabold text-2xl md:text-3xl leading-tight">
                    Selamat Datang, <span class="text-amber-400">{{ Auth::user()->name }}</span>!
                </h1>
                <p class="text-xs md:text-sm text-slate-300 font-medium leading-relaxed">
                    Anda berada di Pusat Kendali AI Buddy. Kelola materi pembelajaran, Few-Shot prompts, akun pengguna, dan monitor statistik penggunaan AI Tutor.
                </p>
            </div>

            <div class="flex flex-wrap gap-3 shrink-0">
                <a href="/admin/topics" class="px-4 py-2.5 rounded-2xl bg-terracotta hover:bg-terracotta-hover text-white font-outfit font-bold text-xs shadow-md transition-all no-underline inline-flex items-center gap-2">
                    <i class="bi bi-plus-circle-fill"></i>
                    <span>Kelola Topik</span>
                </a>
                <a href="/admin/prompts" class="px-4 py-2.5 rounded-2xl bg-slate-700 hover:bg-slate-600 text-white font-outfit font-bold text-xs transition-all no-underline inline-flex items-center gap-2">
                    <i class="bi bi-cpu"></i>
                    <span>Kelola Prompt</span>
                </a>
            </div>
        </div>
    </div>

    <!-- 2. System Stat Cards Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
        <!-- Card 1: Total Siswa -->
        <div class="bg-white border border-slate-200/80 rounded-3xl p-5 shadow-sm hover:shadow-md transition-all flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl shadow-sm shrink-0">
                <i class="bi bi-people-fill"></i>
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-[11px] font-outfit font-bold text-slate-400 uppercase tracking-wider truncate">Siswa Terdaftar</p>
                <h3 class="font-outfit font-extrabold text-2xl text-slate-900 leading-tight">
                    {{ $stats['total_users'] }}
                </h3>
                <span class="text-[10px] font-semibold text-slate-500">Akun Anak (10-14th)</span>
            </div>
        </div>

        <!-- Card 2: Total Topik -->
        <div class="bg-white border border-slate-200/80 rounded-3xl p-5 shadow-sm hover:shadow-md transition-all flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-2xl shadow-sm shrink-0">
                <i class="bi bi-journal-bookmark-fill"></i>
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-[11px] font-outfit font-bold text-slate-400 uppercase tracking-wider truncate">Topik Pelajaran</p>
                <h3 class="font-outfit font-extrabold text-2xl text-slate-900 leading-tight">
                    {{ $stats['total_topics'] }}
                </h3>
                <span class="text-[10px] font-semibold text-slate-500">Materi Aktif</span>
            </div>
        </div>

        <!-- Card 3: Total Prompts -->
        <div class="bg-white border border-slate-200/80 rounded-3xl p-5 shadow-sm hover:shadow-md transition-all flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-2xl shadow-sm shrink-0">
                <i class="bi bi-cpu-fill"></i>
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-[11px] font-outfit font-bold text-slate-400 uppercase tracking-wider truncate">Prompt Few-Shot</p>
                <h3 class="font-outfit font-extrabold text-2xl text-slate-900 leading-tight">
                    {{ $stats['total_prompts'] }}
                </h3>
                <span class="text-[10px] font-semibold text-slate-500">Instruksi AI Model</span>
            </div>
        </div>

        <!-- Card 4: Total Sesi Chat -->
        <div class="bg-white border border-slate-200/80 rounded-3xl p-5 shadow-sm hover:shadow-md transition-all flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl shadow-sm shrink-0">
                <i class="bi bi-chat-dots-fill"></i>
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-[11px] font-outfit font-bold text-slate-400 uppercase tracking-wider truncate">Total Percakapan</p>
                <h3 class="font-outfit font-extrabold text-2xl text-slate-900 leading-tight">
                    {{ $stats['total_sessions'] }}
                </h3>
                <span class="text-[10px] font-semibold text-slate-500">{{ $stats['total_messages'] }} pesan terproses</span>
            </div>
        </div>
    </div>

    <!-- 3. Quick Navigation Shortcut Grid -->
    <div class="space-y-3">
        <h3 class="font-outfit font-extrabold text-lg text-slate-900 flex items-center gap-2">
            <i class="bi bi-grid-3x3-gap-fill text-terracotta"></i>
            <span>Fitur Modul Administrator</span>
        </h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="/admin/users" class="group bg-white border border-slate-200/80 rounded-2xl p-4 hover:border-terracotta hover:shadow-md transition-all no-underline text-slate-800">
                <div class="flex items-center justify-between mb-2">
                    <i class="bi bi-people text-2xl text-blue-600 group-hover:scale-110 transition-transform"></i>
                    <i class="bi bi-arrow-right-short text-slate-400 group-hover:text-terracotta"></i>
                </div>
                <h4 class="font-outfit font-bold text-sm text-slate-900 group-hover:text-terracotta">Manajemen Pengguna</h4>
                <p class="text-[11px] text-slate-500 font-medium">Kelola akun siswa & admin</p>
            </a>

            <a href="/admin/topics" class="group bg-white border border-slate-200/80 rounded-2xl p-4 hover:border-terracotta hover:shadow-md transition-all no-underline text-slate-800">
                <div class="flex items-center justify-between mb-2">
                    <i class="bi bi-journal-bookmark text-2xl text-amber-600 group-hover:scale-110 transition-transform"></i>
                    <i class="bi bi-arrow-right-short text-slate-400 group-hover:text-terracotta"></i>
                </div>
                <h4 class="font-outfit font-bold text-sm text-slate-900 group-hover:text-terracotta">Manajemen Topik</h4>
                <p class="text-[11px] text-slate-500 font-medium">Tambah/edit modul materi</p>
            </a>

            <a href="/admin/prompts" class="group bg-white border border-slate-200/80 rounded-2xl p-4 hover:border-terracotta hover:shadow-md transition-all no-underline text-slate-800">
                <div class="flex items-center justify-between mb-2">
                    <i class="bi bi-cpu text-2xl text-purple-600 group-hover:scale-110 transition-transform"></i>
                    <i class="bi bi-arrow-right-short text-slate-400 group-hover:text-terracotta"></i>
                </div>
                <h4 class="font-outfit font-bold text-sm text-slate-900 group-hover:text-terracotta">Manajemen Prompt</h4>
                <p class="text-[11px] text-slate-500 font-medium">Atur Few-Shot System Prompts</p>
            </a>

            <a href="/admin/example-prompts" class="group bg-white border border-slate-200/80 rounded-2xl p-4 hover:border-terracotta hover:shadow-md transition-all no-underline text-slate-800">
                <div class="flex items-center justify-between mb-2">
                    <i class="bi bi-chat-quote text-2xl text-emerald-600 group-hover:scale-110 transition-transform"></i>
                    <i class="bi bi-arrow-right-short text-slate-400 group-hover:text-terracotta"></i>
                </div>
                <h4 class="font-outfit font-bold text-sm text-slate-900 group-hover:text-terracotta">Example Prompt</h4>
                <p class="text-[11px] text-slate-500 font-medium">Saran pertanyaan per topik</p>
            </a>
        </div>
    </div>

    <!-- 4. Tables Section: Popular Topics & Recent Sessions -->
    <div class="grid lg:grid-cols-2 gap-6">

        <!-- Topik Terpopuler -->
        <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-outfit font-extrabold text-base text-slate-900 flex items-center gap-2">
                        <i class="bi bi-fire text-orange-500"></i> Topik Terpopuler
                    </h3>
                    <p class="text-xs text-slate-500 font-medium">Diurutkan berdasarkan sesi percakapan terbanyak</p>
                </div>
                <a href="/admin/topics" class="text-xs font-outfit font-bold text-terracotta hover:underline no-underline">Lihat Semua</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs font-medium">
                    <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider">
                        <tr>
                            <th class="p-3 rounded-l-xl">Topik</th>
                            <th class="p-3">Sesi Chat</th>
                            <th class="p-3 rounded-r-xl">Saran Pertanyaan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($popularTopics as $topic)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="p-3">
                                    <span class="font-bold text-slate-900 block text-sm">{{ $topic->name }}</span>
                                    <span class="text-[10px] text-slate-400">{{ $topic->slug }}</span>
                                </td>
                                <td class="p-3">
                                    <span class="px-2.5 py-1 rounded-full bg-amber-100 text-amber-800 font-bold">
                                        {{ $topic->chat_sessions_count }} sesi
                                    </span>
                                </td>
                                <td class="p-3 text-slate-600">
                                    {{ $topic->example_prompts_count }} pertanyaan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="p-4 text-center text-slate-400">Belum ada data topik.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Sesi Chat Terbaru Sistem -->
        <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-outfit font-extrabold text-base text-slate-900 flex items-center gap-2">
                        <i class="bi bi-clock-history text-blue-500"></i> Percakapan Terbaru
                    </h3>
                    <p class="text-xs text-slate-500 font-medium">Aktivitas chat siswa secara real-time</p>
                </div>
                <a href="/admin/chat-history" class="text-xs font-outfit font-bold text-terracotta hover:underline no-underline">Lihat Semua</a>
            </div>

            <div class="space-y-3">
                @forelse($recentSessions as $session)
                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/60 flex items-center justify-between gap-3">
                        <div class="min-w-0">
                            <div class="flex items-center gap-2 mb-0.5">
                                <span class="font-outfit font-bold text-xs text-slate-900 truncate">{{ $session->title }}</span>
                                <span class="px-2 py-0.5 rounded-full bg-amber-100 text-terracotta font-bold text-[10px] shrink-0">
                                    {{ $session->topic->name ?? 'Umum' }}
                                </span>
                            </div>
                            <p class="text-[11px] text-slate-500 font-medium truncate">
                                Oleh: <span class="font-bold text-slate-700">{{ $session->user->name ?? 'Siswa' }}</span> • {{ $session->messages_count }} pesan
                            </p>
                        </div>
                        <span class="text-[10px] text-slate-400 font-semibold shrink-0">
                            {{ $session->created_at->diffForHumans() }}
                        </span>
                    </div>
                @empty
                    <div class="p-4 text-center text-xs text-slate-400">Belum ada sesi percakapan aktif.</div>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection
