@extends('layouts.admin')

@section('title', 'Manajemen Topik - AI Buddy Admin')
@section('page_heading', 'Manajemen Topik Pelajaran')
@section('page_subheading', 'Kelola modul topik pelajaran (Matematika, Sains, Bahasa, dll.) dan kuis instruksi AI Tutor')

@section('content')
<div class="space-y-6 animate-fade-in">

    <!-- Header Action & Search Bar -->
    <div class="bg-white border border-slate-200/80 rounded-3xl p-5 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="font-outfit font-extrabold text-xl text-slate-900 flex items-center gap-2">
                <i class="bi bi-journal-bookmark-fill text-amber-500"></i> Modul Topik Belajar
            </h2>
            <p class="text-xs text-slate-500 font-medium mt-0.5">
                Total {{ $topics->total() }} topik pelajaran aktif dalam sistem
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.topics.create') }}" class="px-5 py-2.5 rounded-2xl bg-gradient-to-r from-terracotta to-orange-600 hover:from-terracotta-hover hover:to-orange-700 text-white font-outfit font-bold text-xs shadow-md shadow-terracotta/20 hover:shadow-lg transition-all no-underline inline-flex items-center gap-2">
                <i class="bi bi-plus-circle-fill text-sm"></i>
                <span>+ Tambah Topik Baru</span>
            </a>
        </div>
    </div>

    <!-- Alert Notifications -->
    @if(session('success'))
        <div class="px-4 py-3 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-medium flex items-center gap-2 shadow-sm">
            <i class="bi bi-check-circle-fill text-emerald-500"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="px-4 py-3 rounded-2xl bg-red-50 border border-red-200 text-red-700 text-sm font-medium flex items-center gap-2 shadow-sm">
            <i class="bi bi-exclamation-triangle-fill text-red-500"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Search Form -->
    <div class="bg-white border border-slate-200/80 rounded-3xl p-4 shadow-sm">
        <form method="GET" action="{{ route('admin.topics.index') }}" class="flex items-center gap-3">
            <div class="relative flex-1">
                <i class="bi bi-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari nama topik atau deskripsi..."
                    class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-medium text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-terracotta transition-colors"
                >
            </div>
            <button type="submit" class="px-5 py-2.5 rounded-2xl bg-slate-900 hover:bg-slate-800 text-white font-outfit font-bold text-xs shadow-sm transition-all">
                Cari
            </button>
            @if(request('search'))
                <a href="{{ route('admin.topics.index') }}" class="px-3 py-2.5 rounded-2xl bg-slate-100 text-slate-600 hover:bg-slate-200 font-bold text-xs no-underline" title="Reset Search">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </a>
            @endif
        </form>
    </div>

    <!-- Topics Table Card -->
    <div class="bg-white border border-slate-200/80 rounded-3xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs font-medium">
                <thead class="bg-slate-50 border-b border-slate-200/80 text-slate-500 font-bold uppercase tracking-wider">
                    <tr>
                        <th class="p-4">Topik</th>
                        <th class="p-4">Slug URL</th>
                        <th class="p-4">Deskripsi</th>
                        <th class="p-4">Komponen AI</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @php
                        $topicEmojis = [
                            'matematika'        => '🍕',
                            'sains-ipa'         => '🚀',
                            'bahasa-indonesia'  => '📚',
                            'pengetahuan-umum'  => '🌐',
                        ];
                    @endphp

                    @forelse($topics as $topic)
                        @php $emoji = $topicEmojis[$topic->slug] ?? '📖'; @endphp
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <!-- Topic Info -->
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-2xl bg-amber-100 flex items-center justify-center text-xl shrink-0 shadow-inner">
                                        {{ $emoji }}
                                    </div>
                                    <div class="truncate">
                                        <a href="{{ route('admin.topics.show', $topic->id) }}" class="font-outfit font-bold text-sm text-slate-900 hover:text-terracotta transition-colors no-underline">
                                            {{ $topic->name }}
                                        </a>
                                        <span class="text-[10px] font-semibold block text-slate-400">ID #{{ $topic->id }}</span>
                                    </div>
                                </div>
                            </td>

                            <!-- Slug -->
                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded-xl bg-slate-100 border border-slate-200 font-mono text-[11px] text-slate-700">
                                    {{ $topic->slug }}
                                </span>
                            </td>

                            <!-- Description -->
                            <td class="p-4 text-slate-600 max-w-xs truncate">
                                {{ $topic->description ?? 'Tidak ada deskripsi' }}
                            </td>

                            <!-- AI Components Stats -->
                            <td class="p-4">
                                <div class="space-y-1 text-[11px]">
                                    <span class="px-2 py-0.5 rounded-full bg-purple-100 text-purple-700 font-bold inline-block mr-1">
                                        {{ $topic->prompts_count }} Few-Shot Prompt
                                    </span>
                                    <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 font-bold inline-block mr-1">
                                        {{ $topic->example_prompts_count }} Pertanyaan
                                    </span>
                                    <span class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 font-bold inline-block">
                                        {{ $topic->chat_sessions_count }} Sesi Chat
                                    </span>
                                </div>
                            </td>

                            <!-- Actions -->
                            <td class="p-4 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <!-- Detail Button -->
                                    <a href="{{ route('admin.topics.show', $topic->id) }}" class="p-2 rounded-xl bg-slate-100 hover:bg-blue-500 hover:text-white text-slate-600 transition-colors no-underline" title="Detail Topik">
                                        <i class="bi bi-eye-fill text-sm"></i>
                                    </a>

                                    <!-- Edit Button -->
                                    <a href="{{ route('admin.topics.edit', $topic->id) }}" class="p-2 rounded-xl bg-slate-100 hover:bg-terracotta hover:text-white text-slate-600 transition-colors no-underline" title="Edit Topik">
                                        <i class="bi bi-pencil-square text-sm"></i>
                                    </a>

                                    <!-- Delete Button -->
                                    <form action="{{ route('admin.topics.destroy', $topic->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus topik {{ e($topic->name) }}?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-xl bg-slate-100 hover:bg-red-500 hover:text-white text-slate-600 transition-colors" title="Hapus Topik">
                                            <i class="bi bi-trash3-fill text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-slate-400 font-medium">
                                <div class="text-4xl mb-2">📚</div>
                                <p>Belum ada topik pelajaran dalam sistem.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($topics->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $topics->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
