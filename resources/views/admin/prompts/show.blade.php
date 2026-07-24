@extends('layouts.admin')

@section('title', 'Detail Prompt - Admin AI Buddy')
@section('page_heading', 'Detail System Prompt')
@section('page_subheading', 'Melihat rincian teks Few-Shot System Prompt dan topik terkait')

@section('content')
<div class="max-w-3xl mx-auto space-y-6 animate-fade-in">

    <!-- Header Action Bar -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.prompts.index') }}" class="px-4 py-2 rounded-2xl bg-white border border-slate-200 text-slate-700 font-outfit font-bold text-xs hover:bg-slate-50 transition-all no-underline shadow-sm inline-flex items-center gap-1.5">
            <i class="bi bi-arrow-left text-sm"></i>
            <span>Kembali ke Daftar Prompt</span>
        </a>

        <a href="{{ route('admin.prompts.edit', $prompt->id) }}" class="px-5 py-2.5 rounded-2xl bg-terracotta hover:bg-terracotta-hover text-white font-outfit font-bold text-xs shadow-md transition-all no-underline inline-flex items-center gap-2">
            <i class="bi bi-pencil-square"></i>
            <span>Edit Prompt Ini</span>
        </a>
    </div>

    <!-- Prompt Detail Card -->
    <div class="bg-white border border-slate-200/80 rounded-3xl p-6 md:p-8 shadow-sm space-y-6">
        <div class="flex items-center justify-between flex-wrap gap-3 pb-4 border-b border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-purple-100 text-purple-600 flex items-center justify-center text-xl font-bold">
                    <i class="bi bi-cpu-fill"></i>
                </div>
                <div>
                    <h3 class="font-outfit font-extrabold text-lg text-slate-900">System Prompt ID #{{ $prompt->id }}</h3>
                    <p class="text-xs text-slate-500 font-medium">Terdaftar pada: {{ $prompt->created_at->locale('id')->isoFormat('D MMMM Y, HH:mm') }}</p>
                </div>
            </div>

            <div>
                <span class="px-3 py-1.5 rounded-full bg-purple-100 text-purple-800 text-xs font-bold flex items-center gap-1">
                    📚 Topik: {{ $prompt->topic->name ?? 'Tanpa Topik' }}
                </span>
            </div>
        </div>

        <div class="space-y-2">
            <h4 class="text-xs font-outfit font-bold text-slate-400 uppercase tracking-wider">Teks Few-Shot System Prompt Lengkap:</h4>
            <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 text-slate-800 text-xs md:text-sm font-medium leading-relaxed whitespace-pre-line overflow-x-auto shadow-sm">
                {{ $prompt->prompt_text }}
            </div>
        </div>
    </div>

</div>
@endsection
