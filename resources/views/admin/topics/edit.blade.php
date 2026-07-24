@extends('layouts.admin')

@section('title', 'Edit Topik - Admin AI Buddy')
@section('page_heading', 'Edit Topik Pelajaran')
@section('page_subheading', 'Perbarui data modul materi topik pelajaran')

@section('content')
<div class="max-w-2xl mx-auto space-y-6 animate-fade-in">

    <!-- Header Action Bar -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.topics.index') }}" class="px-4 py-2 rounded-2xl bg-white border border-slate-200 text-slate-700 font-outfit font-bold text-xs hover:bg-slate-50 transition-all no-underline shadow-sm inline-flex items-center gap-1.5">
            <i class="bi bi-arrow-left text-sm"></i>
            <span>Kembali ke Daftar Topik</span>
        </a>
    </div>

    <!-- Edit Form Card -->
    <div class="bg-white border border-slate-200/80 rounded-3xl p-6 md:p-8 shadow-sm space-y-6">
        <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
            <div class="w-12 h-12 rounded-2xl bg-amber-100 text-terracotta flex items-center justify-center text-xl font-bold">
                <i class="bi bi-pencil-square"></i>
            </div>
            <div>
                <h3 class="font-outfit font-extrabold text-lg text-slate-900">Edit Modul Topik</h3>
                <p class="text-xs text-slate-500 font-medium">Mengubah topik: <strong class="text-slate-800">{{ $topic->name }}</strong> (ID #{{ $topic->id }})</p>
            </div>
        </div>

        <form action="{{ route('admin.topics.update', $topic->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

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
                    value="{{ old('name', $topic->name) }}"
                    class="w-full px-4 py-3 bg-slate-50 border {{ $errors->has('name') ? 'border-red-400' : 'border-slate-200' }} rounded-2xl text-sm font-medium text-slate-900 focus:outline-none focus:border-terracotta transition-colors"
                >
                @error('name')
                    <p class="text-xs text-red-500 font-medium pl-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Slug -->
            <div class="space-y-1.5">
                <label for="slug" class="block text-xs font-outfit font-bold text-slate-700">
                    <i class="bi bi-link-45deg text-terracotta mr-1"></i> Slug URL
                </label>
                <input
                    type="text"
                    name="slug"
                    id="slug"
                    value="{{ old('slug', $topic->slug) }}"
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
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium text-slate-900 focus:outline-none focus:border-terracotta transition-colors"
                >{{ old('description', $topic->description) }}</textarea>
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
                    <i class="bi bi-floppy-fill"></i>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
