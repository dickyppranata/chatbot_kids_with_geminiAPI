@extends('layouts.admin')

@section('title', 'Tambah Topik Baru - Admin AI Buddy')
@section('page_heading', 'Tambah Topik Pelajaran')
@section('page_subheading', 'Buat modul materi topik pelajaran baru untuk AI Tutor')

@section('content')
<div class="max-w-2xl mx-auto space-y-6 animate-fade-in">

    <!-- Header Action Bar -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.topics.index') }}" class="px-4 py-2 rounded-2xl bg-white border border-slate-200 text-slate-700 font-outfit font-bold text-xs hover:bg-slate-50 transition-all no-underline shadow-sm inline-flex items-center gap-1.5">
            <i class="bi bi-arrow-left text-sm"></i>
            <span>Kembali ke Daftar Topik</span>
        </a>
    </div>

    <!-- Create Form Card -->
    <div class="bg-white border border-slate-200/80 rounded-3xl p-6 md:p-8 shadow-sm space-y-6">
        <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
            <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center text-xl font-bold">
                <i class="bi bi-journal-plus"></i>
            </div>
            <div>
                <h3 class="font-outfit font-extrabold text-lg text-slate-900">Formulir Topik Baru</h3>
                <p class="text-xs text-slate-500 font-medium">Lengkapi data modul materi topik di bawah ini.</p>
            </div>
        </div>

        <form action="{{ route('admin.topics.store') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Name -->
            <div class="space-y-1.5">
                <label for="name" class="block text-xs font-outfit font-bold text-slate-700">
                    <i class="bi bi-journal-bookmark-fill text-terracotta mr-1"></i> Nama Topik Pelajaran
                </label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    required
                    placeholder="Contoh: Fisika Dasar / Bahasa Inggris"
                    value="{{ old('name') }}"
                    class="w-full px-4 py-3 bg-slate-50 border {{ $errors->has('name') ? 'border-red-400' : 'border-slate-200' }} rounded-2xl text-sm font-medium text-slate-900 focus:outline-none focus:border-terracotta transition-colors"
                >
                @error('name')
                    <p class="text-xs text-red-500 font-medium pl-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Slug (Optional) -->
            <div class="space-y-1.5">
                <label for="slug" class="block text-xs font-outfit font-bold text-slate-700">
                    <i class="bi bi-link-45deg text-terracotta mr-1"></i> Slug URL <span class="text-[10px] text-slate-400 font-normal">(Opsional - Otomatis dibuat jika dikosongkan)</span>
                </label>
                <input
                    type="text"
                    name="slug"
                    id="slug"
                    placeholder="Contoh: fisika-dasar"
                    value="{{ old('slug') }}"
                    class="w-full px-4 py-3 bg-slate-50 border {{ $errors->has('slug') ? 'border-red-400' : 'border-slate-200' }} rounded-2xl text-sm font-medium text-slate-900 focus:outline-none focus:border-terracotta transition-colors"
                >
                @error('slug')
                    <p class="text-xs text-red-500 font-medium pl-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="space-y-1.5">
                <label for="description" class="block text-xs font-outfit font-bold text-slate-700">
                    <i class="bi bi-card-text text-terracotta mr-1"></i> Deskripsi Singkat Materi
                </label>
                <textarea
                    name="description"
                    id="description"
                    rows="3"
                    placeholder="Jelaskan ringkasan materi topik ini untuk anak SD/SMP..."
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium text-slate-900 focus:outline-none focus:border-terracotta transition-colors"
                >{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-xs text-red-500 font-medium pl-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="pt-2 flex justify-end gap-3">
                <a href="{{ route('admin.topics.index') }}" class="px-5 py-3 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-outfit font-bold text-xs transition-all no-underline">
                    Batal
                </a>
                <button
                    type="submit"
                    class="px-6 py-3 rounded-2xl bg-gradient-to-r from-terracotta to-orange-600 hover:from-terracotta-hover hover:to-orange-700 text-white font-outfit font-bold text-xs shadow-md transition-all flex items-center gap-2"
                >
                    <i class="bi bi-check-circle-fill"></i>
                    <span>Simpan Topik Baru</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
