@extends('layouts.admin')

@section('title', 'Tambah Example Prompt - Admin AI Buddy')
@section('page_heading', 'Tambah Contoh Pertanyaan')
@section('page_subheading', 'Buat contoh saran pertanyaan baru per topik untuk memudahkan siswa memulai diskusi')

@section('content')
<div class="max-w-2xl mx-auto space-y-6 animate-fade-in">

    <!-- Header Action Bar -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.example-prompts.index') }}" class="px-4 py-2 rounded-2xl bg-white border border-slate-200 text-slate-700 font-outfit font-bold text-xs hover:bg-slate-50 transition-all no-underline shadow-sm inline-flex items-center gap-1.5">
            <i class="bi bi-arrow-left text-sm"></i>
            <span>Kembali ke Daftar Contoh Pertanyaan</span>
        </a>
    </div>

    <!-- Create Form Card -->
    <div class="bg-white border border-slate-200/80 rounded-3xl p-6 md:p-8 shadow-sm space-y-6">
        <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
            <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-xl font-bold">
                <i class="bi bi-chat-quote-fill"></i>
            </div>
            <div>
                <h3 class="font-outfit font-extrabold text-lg text-slate-900">Formulir Contoh Pertanyaan Baru</h3>
                <p class="text-xs text-slate-500 font-medium">Pilih topik pelajaran dan tuliskan kalimat saran pertanyaan siswa.</p>
            </div>
        </div>

        <form action="{{ route('admin.example-prompts.store') }}" method="POST" class="space-y-5">
            @csrf

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
                    <option value="">-- Pilih Topik Pelajaran --</option>
                    @foreach($topics as $topic)
                        <option value="{{ $topic->id }}" {{ old('topic_id') == $topic->id ? 'selected' : '' }}>
                            📚 {{ $topic->name }} (slug: {{ $topic->slug }})
                        </option>
                    @endforeach
                </select>
                @error('topic_id')
                    <p class="text-xs text-red-500 font-medium pl-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Question Text -->
            <div class="space-y-1.5">
                <label for="question_text" class="block text-xs font-outfit font-bold text-slate-700">
                    <i class="bi bi-chat-dots-fill text-terracotta mr-1"></i> Teks Contoh Pertanyaan Siswa
                </label>
                <input
                    type="text"
                    name="question_text"
                    id="question_text"
                    required
                    placeholder="Contoh: Mengapa planet Pluto tidak lagi disebut planet?"
                    value="{{ old('question_text') }}"
                    class="w-full px-4 py-3 bg-slate-50 border {{ $errors->has('question_text') ? 'border-red-400' : 'border-slate-200' }} rounded-2xl text-sm font-medium text-slate-900 focus:outline-none focus:border-terracotta transition-colors"
                >
                @error('question_text')
                    <p class="text-xs text-red-500 font-medium pl-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="pt-2 flex justify-end gap-3">
                <a href="{{ route('admin.example-prompts.index') }}" class="px-5 py-3 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-outfit font-bold text-xs transition-all no-underline">
                    Batal
                </a>
                <button
                    type="submit"
                    class="px-6 py-3 rounded-2xl bg-gradient-to-r from-terracotta to-orange-600 hover:from-terracotta-hover hover:to-orange-700 text-white font-outfit font-bold text-xs shadow-md transition-all flex items-center gap-2"
                >
                    <i class="bi bi-check-circle-fill"></i>
                    <span>Simpan Contoh Pertanyaan</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
