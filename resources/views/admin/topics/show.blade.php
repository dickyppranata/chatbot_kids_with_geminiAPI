@extends('layouts.admin')

@section('title', 'Detail Topik - Admin AI Buddy')
@section('page_heading', 'Detail Topik Pelajaran')
@section('page_subheading', 'Informasi modul materi, instruksi Few-Shot Prompt AI, dan saran pertanyaan')

@section('content')
<div class="max-w-4xl mx-auto space-y-6 animate-fade-in">

    <!-- Header Action Bar -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.topics.index') }}" class="px-4 py-2 rounded-2xl bg-white border border-slate-200 text-slate-700 font-outfit font-bold text-xs hover:bg-slate-50 transition-all no-underline shadow-sm inline-flex items-center gap-1.5">
            <i class="bi bi-arrow-left text-sm"></i>
            <span>Kembali ke Daftar Topik</span>
        </a>

        <a href="{{ route('admin.topics.edit', $topic->id) }}" class="px-5 py-2.5 rounded-2xl bg-terracotta hover:bg-terracotta-hover text-white font-outfit font-bold text-xs shadow-md transition-all no-underline inline-flex items-center gap-2">
            <i class="bi bi-pencil-square"></i>
            <span>Edit Topik Ini</span>
        </a>
    </div>

    <!-- Topic Card Header -->
    <div class="bg-white border border-slate-200/80 rounded-3xl p-6 md:p-8 shadow-sm space-y-4">
        <div class="flex items-center justify-between flex-wrap gap-4 pb-4 border-b border-slate-100">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-gradient-to-br from-amber-400 to-terracotta rounded-2xl flex items-center justify-center text-white text-3xl shadow-md">
                    📚
                </div>
                <div>
                    <h2 class="font-outfit font-extrabold text-2xl text-slate-900 tracking-tight">
                        {{ $topic->name }}
                    </h2>
                    <span class="text-xs font-mono px-2.5 py-0.5 rounded-full bg-slate-100 border border-slate-200 text-slate-600 mt-1 inline-block">
                        slug: {{ $topic->slug }}
                    </span>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <span class="px-3 py-1.5 rounded-full bg-amber-100 text-amber-800 text-xs font-bold">
                    {{ $topic->chat_sessions_count }} Sesi Chat Siswa
                </span>
            </div>
        </div>

        <div>
            <h4 class="text-xs font-outfit font-bold text-slate-400 uppercase tracking-wider mb-1">Deskripsi Topik</h4>
            <p class="text-sm text-slate-700 leading-relaxed font-medium">
                {{ $topic->description ?? 'Belum ada deskripsi yang ditambahkan untuk topik ini.' }}
            </p>
        </div>
    </div>

    <!-- Linked Few-Shot System Prompts -->
    <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <h3 class="font-outfit font-extrabold text-base text-slate-900 flex items-center gap-2">
                <i class="bi bi-cpu-fill text-purple-600"></i> Few-Shot System Prompts ({{ $topic->prompts->count() }})
            </h3>
        </div>

        <div class="space-y-3">
            @forelse($topic->prompts as $prompt)
                <div class="p-4 rounded-2xl bg-purple-50/50 border border-purple-100 text-xs font-medium text-slate-800 space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-purple-700 font-outfit">System Prompt #{{ $prompt->id }}</span>
                        <span class="text-[10px] text-slate-400">{{ $prompt->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-slate-700 leading-relaxed whitespace-pre-line">{{ $prompt->prompt_text }}</p>
                </div>
            @empty
                <p class="text-xs text-slate-400 italic py-2">Belum ada Few-Shot prompt khusus yang dikaitkan dengan topik ini.</p>
            @endforelse
        </div>
    </div>

    <!-- Linked Example Prompts (Saran Pertanyaan) -->
    <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <h3 class="font-outfit font-extrabold text-base text-slate-900 flex items-center gap-2">
                <i class="bi bi-chat-quote-fill text-emerald-600"></i> Example Prompts / Saran Pertanyaan ({{ $topic->examplePrompts->count() }})
            </h3>
        </div>

        <div class="grid sm:grid-cols-2 gap-3">
            @forelse($topic->examplePrompts as $ep)
                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/60 text-xs font-semibold text-slate-800 flex items-center gap-2">
                    <span class="text-terracotta">💬</span>
                    <span>"{{ $ep->question_text }}"</span>
                </div>
            @empty
                <div class="sm:col-span-2 text-xs text-slate-400 italic py-2">Belum ada contoh pertanyaan saran yang ditambahkan.</div>
            @endforelse
        </div>
    </div>

</div>
@endsection
