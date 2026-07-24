@extends('layouts.admin')

@section('title', 'Tambah Prompt Baru - Admin AI Buddy')
@section('page_heading', 'Tambah Few-Shot Prompt')
@section('page_subheading', 'Buat instruksi Few-Shot System Prompt baru untuk membimbing karakter AI Tutor')

@section('content')
<div class="max-w-3xl mx-auto space-y-6 animate-fade-in">

    <!-- Header Action Bar -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.prompts.index') }}" class="px-4 py-2 rounded-2xl bg-white border border-slate-200 text-slate-700 font-outfit font-bold text-xs hover:bg-slate-50 transition-all no-underline shadow-sm inline-flex items-center gap-1.5">
            <i class="bi bi-arrow-left text-sm"></i>
            <span>Kembali ke Daftar Prompt</span>
        </a>
    </div>

    <!-- Create Form Card -->
    <div class="bg-white border border-slate-200/80 rounded-3xl p-6 md:p-8 shadow-sm space-y-6">
        <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
            <div class="w-12 h-12 rounded-2xl bg-purple-100 text-purple-600 flex items-center justify-center text-xl font-bold">
                <i class="bi bi-cpu-fill"></i>
            </div>
            <div>
                <h3 class="font-outfit font-extrabold text-lg text-slate-900">Formulir System Prompt Baru</h3>
                <p class="text-xs text-slate-500 font-medium">Pilih topik pelajaran dan tuliskan teks instruksi Few-Shot untuk AI Tutor.</p>
            </div>
        </div>

        <form action="{{ route('admin.prompts.store') }}" method="POST" class="space-y-5">
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

            <!-- Prompt Text Area -->
            <div class="space-y-1.5">
                <div class="flex items-center justify-between">
                    <label for="prompt_text" class="block text-xs font-outfit font-bold text-slate-700">
                        <i class="bi bi-code-square text-terracotta mr-1"></i> Teks Few-Shot System Prompt
                    </label>
                    <span class="text-[11px] text-purple-600 font-semibold">💡 Tips: Berikan contoh percakapan konkret (Few-Shot)</span>
                </div>

                <textarea
                    name="prompt_text"
                    id="prompt_text"
                    rows="8"
                    required
                    placeholder="Tuliskan instruksi karakter AI Tutor, nada penyampaian untuk siswa SD/SMP (10-14th), serta contoh format Few-Shot..."
                    class="w-full px-4 py-3 bg-slate-50 border {{ $errors->has('prompt_text') ? 'border-red-400' : 'border-slate-200' }} rounded-2xl font-mono text-xs text-slate-900 leading-relaxed focus:outline-none focus:border-terracotta transition-colors"
                >{{ old('prompt_text') }}</textarea>

                @error('prompt_text')
                    <p class="text-xs text-red-500 font-medium pl-1">{{ $message }}</p>
                @enderror

                <div class="p-3 bg-purple-50/60 border border-purple-100 rounded-2xl text-[11px] text-purple-900 font-medium space-y-1">
                    <p class="font-bold flex items-center gap-1">
                        <i class="bi bi-lightbulb-fill text-amber-500"></i> Panduan Penyusunan Prompt Edukasi Anak:
                    </p>
                    <ul class="list-disc list-inside space-y-0.5 text-purple-800 text-[10px]">
                        <li>Gunakan nada ramah, penyabar, dan tidak menghakimi ("Kakak AI Tutor").</li>
                        <li>Sertakan contoh analogi dunia nyata (seperti pizza untuk pecahan).</li>
                        <li>Gunakan format markdown tebal `**kata penting**` dan emoji pendukung.</li>
                    </ul>
                </div>
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
                    <i class="bi bi-check-circle-fill"></i>
                    <span>Simpan System Prompt</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
