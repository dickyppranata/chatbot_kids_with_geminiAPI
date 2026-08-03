@extends('layouts.admin')

@section('title', 'Riwayat Percakapan Siswa - AI Buddy Admin')
@section('page_heading', 'Riwayat Percakapan Siswa')
@section('page_subheading', 'Pantau aktivitas dan konsultasi belajar siswa dengan AI Tutor berdasarkan pengelompokan pengguna')

@section('content')
<div class="space-y-6 animate-fade-in">

    <!-- Top Stats Cards Summary -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <!-- Stat 1: Total Siswa Aktif Chat -->
        <div class="bg-white border border-slate-200/80 rounded-3xl p-5 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center text-2xl font-bold shrink-0">
                <i class="bi bi-people-fill"></i>
            </div>
            <div>
                <p class="text-xs font-outfit font-bold text-slate-400 uppercase tracking-wider">Siswa Aktif Chat</p>
                <h3 class="font-outfit font-black text-2xl text-slate-900 mt-0.5">{{ number_format($totalActiveStudents) }}</h3>
            </div>
        </div>

        <!-- Stat 2: Total Sesi Chat -->
        <div class="bg-white border border-slate-200/80 rounded-3xl p-5 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-purple-100 text-purple-600 flex items-center justify-center text-2xl font-bold shrink-0">
                <i class="bi bi-chat-left-text-fill"></i>
            </div>
            <div>
                <p class="text-xs font-outfit font-bold text-slate-400 uppercase tracking-wider">Total Sesi Chat</p>
                <h3 class="font-outfit font-black text-2xl text-slate-900 mt-0.5">{{ number_format($totalSessions) }}</h3>
            </div>
        </div>

        <!-- Stat 3: Total Pesan Terkirim -->
        <div class="bg-white border border-slate-200/80 rounded-3xl p-5 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-2xl font-bold shrink-0">
                <i class="bi bi-chat-dots-fill"></i>
            </div>
            <div>
                <p class="text-xs font-outfit font-bold text-slate-400 uppercase tracking-wider">Total Pesan Terkirim</p>
                <h3 class="font-outfit font-black text-2xl text-slate-900 mt-0.5">{{ number_format($totalMessages) }}</h3>
            </div>
        </div>
    </div>

    <!-- Alert Notifications -->
    @if(session('success'))
        <div class="px-4 py-3 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-medium flex items-center gap-2 shadow-sm">
            <i class="bi bi-check-circle-fill text-emerald-500"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Filter & Search Section -->
    <div class="bg-white border border-slate-200/80 rounded-3xl p-4 shadow-sm">
        <form method="GET" action="{{ route('admin.chat-history.index') }}" class="grid md:grid-cols-12 gap-3 items-center">
            <!-- Search Input -->
            <div class="md:col-span-6 relative">
                <i class="bi bi-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari nama atau email siswa..."
                    class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-medium text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-terracotta transition-colors"
                >
            </div>

            <!-- Topic Filter -->
            <div class="md:col-span-4">
                <select name="topic_id" onchange="this.form.submit()" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-medium text-slate-900 focus:outline-none focus:border-terracotta transition-colors">
                    <option value="">Semua Topik Pelajaran</option>
                    @foreach($topics as $topic)
                        <option value="{{ $topic->id }}" {{ request('topic_id') == $topic->id ? 'selected' : '' }}>
                            📚 {{ $topic->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="md:col-span-2 flex items-center gap-2">
                <button type="submit" class="w-full py-2.5 rounded-2xl bg-slate-900 hover:bg-slate-800 text-white font-outfit font-bold text-xs shadow-sm transition-all">
                    Cari
                </button>
                @if(request('search') || request('topic_id'))
                    <a href="{{ route('admin.chat-history.index') }}" class="px-3 py-2.5 rounded-2xl bg-slate-100 text-slate-600 hover:bg-slate-200 font-bold text-xs no-underline" title="Reset Filter">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- User Grouping Table / Card List -->
    <div class="bg-white border border-slate-200/80 rounded-3xl shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <h2 class="font-outfit font-extrabold text-lg text-slate-900 flex items-center gap-2">
                <i class="bi bi-person-lines-fill text-terracotta"></i> Pengelompokan Percakapan per Siswa
            </h2>
            <span class="text-xs font-semibold text-slate-500">Menampilkan {{ $users->total() }} siswa</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs font-medium">
                <thead class="bg-slate-50 border-b border-slate-200/80 text-slate-500 font-bold uppercase tracking-wider">
                    <tr>
                        <th class="p-4">Siswa</th>
                        <th class="p-4">Total Sesi Chat</th>
                        <th class="p-4">Sesi Percakapan Terakhir</th>
                        <th class="p-4">Topik Terbaru</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                        @php
                            $latestSession = $user->chatSessions->first();
                            $initials = strtoupper(substr($user->name, 0, 2));
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <!-- Student Profile Info -->
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-amber-400 to-terracotta text-white font-bold flex items-center justify-center text-xs shrink-0 shadow-inner">
                                        {{ $initials }}
                                    </div>
                                    <div class="truncate">
                                        <a href="{{ route('admin.chat-history.show', $user->id) }}" class="font-outfit font-bold text-sm text-slate-900 hover:text-terracotta transition-colors no-underline">
                                            {{ $user->name }}
                                        </a>
                                        <span class="text-[11px] text-slate-400 block font-medium">{{ $user->email }}</span>
                                    </div>
                                </div>
                            </td>

                            <!-- Total Sesi & Pesan -->
                            <td class="p-4">
                                <div class="space-y-1">
                                    <span class="px-2.5 py-1 rounded-full bg-purple-100 text-purple-800 font-bold text-[11px] inline-block">
                                        {{ $user->chat_sessions_count }} Sesi Chat
                                    </span>
                                    @if($latestSession)
                                        <span class="text-[10px] text-slate-400 block font-medium">
                                            Total {{ $latestSession->messages_count ?? 0 }} pesan di sesi terbaru
                                        </span>
                                    @endif
                                </div>
                            </td>

                            <!-- Latest Session Info -->
                            <td class="p-4 max-w-xs">
                                @if($latestSession)
                                    <div class="truncate">
                                        <span class="font-outfit font-bold text-slate-800 block truncate">
                                            "{{ $latestSession->title }}"
                                        </span>
                                        <span class="text-[10px] text-slate-400 font-medium">
                                            <i class="bi bi-clock mr-0.5"></i> {{ $latestSession->updated_at->diffForHumans() }}
                                        </span>
                                    </div>
                                @else
                                    <span class="text-slate-400 italic text-[11px]">Belum ada sesi chat</span>
                                @endif
                            </td>

                            <!-- Latest Topic Badge -->
                            <td class="p-4">
                                @if($latestSession && $latestSession->topic)
                                    <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-800 font-bold text-[11px] inline-block">
                                        📚 {{ $latestSession->topic->name }}
                                    </span>
                                @else
                                    <span class="text-slate-400 italic text-[11px]">-</span>
                                @endif
                            </td>

                            <!-- Action Link -->
                            <td class="p-4 text-center">
                                <a href="{{ route('admin.chat-history.show', $user->id) }}" class="px-4 py-2 rounded-2xl bg-terracotta hover:bg-terracotta-hover text-white font-outfit font-bold text-xs shadow-sm transition-all no-underline inline-flex items-center gap-1.5">
                                    <i class="bi bi-eye-fill"></i>
                                    <span>Lihat Percakapan ({{ $user->chat_sessions_count }})</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-slate-400 font-medium">
                                <div class="text-4xl mb-2">💬</div>
                                <p>Tidak ada riwayat percakapan siswa yang sesuai pencarian.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $users->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
