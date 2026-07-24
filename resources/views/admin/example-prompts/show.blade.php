@extends('layouts.admin')

@section('title', 'Detail Example Prompt - Admin AI Buddy')
@section('page_heading', 'Detail Contoh Pertanyaan')
@section('page_subheading', 'Melihat rincian teks contoh saran pertanyaan dan topik terkait')

@section('content')
<div class="max-w-2xl mx-auto space-y-6 animate-fade-in">

    <!-- Header Action Bar -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.example-prompts.index') }}" class="px-4 py-2 rounded-2xl bg-white border border-slate-200 text-slate-700 font-outfit font-bold text-xs hover:bg-slate-50 transition-all no-underline shadow-sm inline-flex items-center gap-1.5">
            <i class="bi bi-arrow-left text-sm"></i>
            <span>Kembali ke Daftar Contoh Pertanyaan</span>
        </a>

        <a href="{{ route('admin.example-prompts.edit', $examplePrompt->id) }}" class="px-5 py-2.5 rounded-2xl bg-terracotta hover:bg-terracotta-hover text-white font-outfit font-bold text-xs shadow-md transition-all no-underline inline-flex items-center gap-2">
            <i class="bi bi-pencil-square"></i>
            <span>Edit Pertanyaan Ini</span>
        </a>
    </div>

    <!-- Detail Card -->
    <div class="bg-white border border-slate-200/80 rounded-3xl p-6 md:p-8 shadow-sm space-y-6">
        <div class="flex items-center justify-between flex-wrap gap-3 pb-4 border-b border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-xl font-bold">
                    <i class="bi bi-chat-quote-fill"></i>
                </div>
                <div>
                    <h3 class="font-outfit font-extrabold text-lg text-slate-900">Example Prompt ID #{{ $examplePrompt->id }}</h3>
                    <p class="text-xs text-slate-500 font-medium">Terdaftar pada: {{ $examplePrompt->created_at->locale('id')->isoFormat('D MMMM Y, HH:mm') }}</p>
                </div>
            </div>

            <div>
                <span class="px-3 py-1.5 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold flex items-center gap-1">
                    📚 Topik: {{ $examplePrompt->topic->name ?? 'Tanpa Topik' }}
                </span>
            </div>
        </div>

        <div class="space-y-2">
            <h4 class="text-xs font-outfit font-bold text-slate-400 uppercase tracking-wider">Teks Pertanyaan Siswa:</h4>
            <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 text-slate-800 text-sm font-semibold leading-relaxed shadow-sm">
                💬 "{{ $examplePrompt->question_text }}"
            </div>
        </div>

        <!-- Preview Button -->
        <div class="pt-2 border-t border-slate-100">
            <p class="text-xs text-slate-500 font-medium mb-2">Uji coba pertanyaan ini langsung di area percakapan tutor:</p>
            <a href="/chat?topic_id={{ $examplePrompt->topic_id }}&prompt={{ urlencode($examplePrompt->question_text) }}" target="_blank" class="px-4 py-2.5 rounded-2xl bg-amber-50 border border-amber-200 text-terracotta hover:bg-amber-100 font-outfit font-bold text-xs transition-all inline-flex items-center gap-2 no-underline">
                <i class="bi bi-box-arrow-up-right"></i>
                <span>Coba Pertanyaan di Chat Tutor</span>
            </a>
        </div>
    </div>

</div>
@endsection
