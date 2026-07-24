@extends('layouts.admin')

@section('title', 'Edit Prompt - Admin AI Buddy')
@section('page_heading', 'Edit System Prompt')
@section('page_subheading', 'Perbarui instruksi Few-Shot System Prompt untuk topik pelajaran')

@section('content')
<div class="max-w-3xl mx-auto space-y-6 animate-fade-in">

    <!-- Header Action Bar -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.prompts.index') }}" class="px-4 py-2 rounded-2xl bg-white border border-slate-200 text-slate-700 font-outfit font-bold text-xs hover:bg-slate-50 transition-all no-underline shadow-sm inline-flex items-center gap-1.5">
            <i class="bi bi-arrow-left text-sm"></i>
            <span>Kembali ke Daftar Prompt</span>
        </a>
    </div>

    <!-- Edit Form Card -->
    <div class="bg-white border border-slate-200/80 rounded-3xl p-6 md:p-8 shadow-sm space-y-6">
        <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
            <div class="w-12 h-12 rounded-2xl bg-amber-100 text-terracotta flex items-center justify-center text-xl font-bold">
                <i class="bi bi-pencil-square"></i>
            </div>
            <div>
                <h3 class="font-outfit font-extrabold text-lg text-slate-900">Edit System Prompt ID #{{ $prompt->id }}</h3>
                <p class="text-xs text-slate-500 font-medium">Perbarui teks instruksi dan topik yang terkait.</p>
            </div>
        </div>

        <form action="{{ route('admin.prompts.update', $prompt->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Topic Selection -->
            <div class="space-y-1.5">
                <label for="topic_id" class="block text-xs font-outfit font-bold text-slate-700">
                    <i class="bi bi-journal-bookmark-fill text-terracotta mr-1"></i> Topik Pelajaran
                </label>
                <select
                    name="topic_id"
                    id="topic_id"
                    required
                    class="w-full px-4 py-3 bg-slate-50 border {{ $errors->has('topic_id') ? 'border-red-400' : 'border-slate-200' }} rounded-2xl text-sm font-medium text-slate-900 focus:outline-none focus:border-terracotta transition-colors"
                >
                    @foreach($topics as $topic)
                        <option value="{{ $topic->id }}" {{ old('topic_id', $prompt->topic_id) == $topic->id ? 'selected' : '' }}>
                            📚 {{ $topic->name }} (slug: {{ $topic->slug }})
                        </option>
                    @endforeach
                </select>
                @error('topic_id')
                    <p class="text-xs text-red-500 font-medium pl-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Prompt Text Area -->
            <div class="space-y-1.5">
                <label for="prompt_text" class="block text-xs font-outfit font-bold text-slate-700">
                    <i class="bi bi-code-square text-terracotta mr-1"></i> Teks Few-Shot System Prompt
                </label>
                <textarea
                    name="prompt_text"
                    id="prompt_text"
                    rows="8"
                    required
                    class="w-full px-4 py-3 bg-slate-50 border {{ $errors->has('prompt_text') ? 'border-red-400' : 'border-slate-200' }} rounded-2xl font-mono text-xs text-slate-900 leading-relaxed focus:outline-none focus:border-terracotta transition-colors"
                >{{ old('prompt_text', $prompt->prompt_text) }}</textarea>
                @error('prompt_text')
                    <p class="text-xs text-red-500 font-medium pl-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="pt-2 flex justify-end gap-3">
                <a href="{{ route('admin.prompts.index') }}" class="px-5 py-3 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-outfit font-bold text-xs transition-all no-underline">
                    Batal
                </a>
                <button
                    type="submit"
                    class="px-6 py-3 rounded-2xl bg-gradient-to-r from-terracotta to-orange-600 hover:from-terracotta-hover hover:to-orange-700 text-white font-outfit font-bold text-xs shadow-md transition-all flex items-center gap-2"
                >
                    <i class="bi bi-floppy-fill"></i>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
