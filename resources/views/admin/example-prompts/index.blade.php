@extends('layouts.admin')

@section('title', 'Example Prompts - AI Buddy Admin')
@section('page_heading', 'Manajemen Example Prompts (Saran Pertanyaan)')
@section('page_subheading', 'Kelola contoh saran pertanyaan per topik yang tampil pada dashboard & chat siswa')

@section('content')
<div class="space-y-6 animate-fade-in">

    <!-- Header Action Bar -->
    <div class="bg-white border border-slate-200/80 rounded-3xl p-5 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="font-outfit font-extrabold text-xl text-slate-900 flex items-center gap-2">
                <i class="bi bi-chat-quote-fill text-emerald-600"></i> Contoh Saran Pertanyaan
            </h2>
            <p class="text-xs text-slate-500 font-medium mt-0.5">
                Total {{ $examplePrompts->total() }} saran pertanyaan tersimpan dalam sistem
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.example-prompts.create') }}" class="px-5 py-2.5 rounded-2xl bg-gradient-to-r from-terracotta to-orange-600 hover:from-terracotta-hover hover:to-orange-700 text-white font-outfit font-bold text-xs shadow-md shadow-terracotta/20 hover:shadow-lg transition-all no-underline inline-flex items-center gap-2">
                <i class="bi bi-plus-circle-fill text-sm"></i>
                <span>+ Tambah Contoh Pertanyaan</span>
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

    <!-- Search & Filter Form -->
    <div class="bg-white border border-slate-200/80 rounded-3xl p-4 shadow-sm">
        <form method="GET" action="{{ route('admin.example-prompts.index') }}" class="grid md:grid-cols-12 gap-3 items-center">
            <!-- Search Input -->
            <div class="md:col-span-6 relative">
                <i class="bi bi-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari teks pertanyaan..."
                    class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-medium text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-terracotta transition-colors"
                >
            </div>

            <!-- Topic Filter -->
            <div class="md:col-span-4">
                <select name="topic_id" onchange="this.form.submit()" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-medium text-slate-900 focus:outline-none focus:border-terracotta transition-colors">
                    <option value="">Semua Topik Pelajaran</option>
                    @foreach($topics as $topic)
                        <option value="{{ $topic->id }}" {{ request('topic_id') == $topic->id ? 'selected' : '' }}>
                            {{ $topic->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Submit & Reset Buttons -->
            <div class="md:col-span-2 flex items-center gap-2">
                <button type="submit" class="w-full py-2.5 rounded-2xl bg-slate-900 hover:bg-slate-800 text-white font-outfit font-bold text-xs shadow-sm transition-all">
                    Cari
                </button>
                @if(request('search') || request('topic_id'))
                    <a href="{{ route('admin.example-prompts.index') }}" class="px-3 py-2.5 rounded-2xl bg-slate-100 text-slate-600 hover:bg-slate-200 font-bold text-xs no-underline" title="Reset Filter">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table Card -->
    <div class="bg-white border border-slate-200/80 rounded-3xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs font-medium">
                <thead class="bg-slate-50 border-b border-slate-200/80 text-slate-500 font-bold uppercase tracking-wider">
                    <tr>
                        <th class="p-4">ID & Topik</th>
                        <th class="p-4">Contoh Teks Pertanyaan Siswa</th>
                        <th class="p-4">Dibuat Pada</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($examplePrompts as $ep)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <!-- ID & Topic -->
                            <td class="p-4 whitespace-nowrap">
                                <span class="text-[10px] font-bold text-slate-400 block">ID #{{ $ep->id }}</span>
                                <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 font-bold text-[11px] inline-block mt-1">
                                    📚 {{ $ep->topic->name ?? 'Tanpa Topik' }}
                                </span>
                            </td>

                            <!-- Question Text Chip -->
                            <td class="p-4">
                                <div class="p-3 rounded-2xl bg-amber-50/60 border border-amber-200/60 text-xs font-semibold text-slate-800 leading-relaxed inline-flex items-center gap-2">
                                    <span class="text-terracotta">💬</span>
                                    <span>"{{ $ep->question_text }}"</span>
                                </div>
                            </td>

                            <!-- Created Date -->
                            <td class="p-4 text-slate-500 font-medium whitespace-nowrap">
                                {{ $ep->created_at->locale('id')->isoFormat('D MMM Y, HH:mm') }}
                            </td>

                            <!-- Actions -->
                            <td class="p-4 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <!-- Detail Button -->
                                    <a href="{{ route('admin.example-prompts.show', $ep->id) }}" class="p-2 rounded-xl bg-slate-100 hover:bg-blue-500 hover:text-white text-slate-600 transition-colors no-underline" title="Detail Contoh Pertanyaan">
                                        <i class="bi bi-eye-fill text-sm"></i>
                                    </a>

                                    <!-- Edit Button -->
                                    <a href="{{ route('admin.example-prompts.edit', $ep->id) }}" class="p-2 rounded-xl bg-slate-100 hover:bg-terracotta hover:text-white text-slate-600 transition-colors no-underline" title="Edit Contoh Pertanyaan">
                                        <i class="bi bi-pencil-square text-sm"></i>
                                    </a>

                                    <!-- Delete Button -->
                                    <form action="{{ route('admin.example-prompts.destroy', $ep->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus contoh pertanyaan ini?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-xl bg-slate-100 hover:bg-red-500 hover:text-white text-slate-600 transition-colors" title="Hapus Contoh Pertanyaan">
                                            <i class="bi bi-trash3-fill text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-8 text-center text-slate-400 font-medium">
                                <div class="text-4xl mb-2">💬</div>
                                <p>Belum ada contoh pertanyaan tersimpan dalam sistem.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($examplePrompts->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $examplePrompts->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
