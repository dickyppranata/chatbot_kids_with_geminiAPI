@extends('layouts.admin')

@section('title', 'Edit Pengguna - Admin AI Buddy')
@section('page_heading', 'Edit Data Pengguna')
@section('page_subheading', 'Perbarui informasi profil dan hak akses pengguna sistem')

@section('content')
<div class="max-w-2xl mx-auto space-y-6 animate-fade-in">

    <!-- Header Action Bar -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.users.index') }}" class="px-4 py-2 rounded-2xl bg-white border border-slate-200 text-slate-700 font-outfit font-bold text-xs hover:bg-slate-50 transition-all no-underline shadow-sm inline-flex items-center gap-1.5">
            <i class="bi bi-arrow-left text-sm"></i>
            <span>Kembali ke Daftar Pengguna</span>
        </a>
    </div>

    <!-- Edit User Form Card -->
    <div class="bg-white border border-slate-200/80 rounded-3xl p-6 md:p-8 shadow-sm space-y-6">
        <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
            <div class="w-12 h-12 rounded-2xl bg-amber-100 text-terracotta flex items-center justify-center text-xl font-bold">
                <i class="bi bi-pencil-square"></i>
            </div>
            <div>
                <h3 class="font-outfit font-extrabold text-lg text-slate-900">Perbarui Data Akun</h3>
                <p class="text-xs text-slate-500 font-medium">Mengubah data akun: <strong class="text-slate-800">{{ $user->name }}</strong> (ID #{{ $user->id }})</p>
            </div>
        </div>

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div class="space-y-1.5">
                <label for="name" class="block text-xs font-outfit font-bold text-slate-700">
                    <i class="bi bi-person-fill text-terracotta mr-1"></i> Nama Lengkap
                </label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    required
                    value="{{ old('name', $user->name) }}"
                    class="w-full px-4 py-3 bg-slate-50 border {{ $errors->has('name') ? 'border-red-400' : 'border-slate-200' }} rounded-2xl text-sm font-medium text-slate-900 focus:outline-none focus:border-terracotta transition-colors"
                >
                @error('name')
                    <p class="text-xs text-red-500 font-medium pl-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="space-y-1.5">
                <label for="email" class="block text-xs font-outfit font-bold text-slate-700">
                    <i class="bi bi-envelope-fill text-terracotta mr-1"></i> Alamat Email
                </label>
                <input
                    type="email"
                    name="email"
                    id="email"
                    required
                    value="{{ old('email', $user->email) }}"
                    class="w-full px-4 py-3 bg-slate-50 border {{ $errors->has('email') ? 'border-red-400' : 'border-slate-200' }} rounded-2xl text-sm font-medium text-slate-900 focus:outline-none focus:border-terracotta transition-colors"
                >
                @error('email')
                    <p class="text-xs text-red-500 font-medium pl-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Role Selection -->
            <div class="space-y-1.5">
                <label for="role" class="block text-xs font-outfit font-bold text-slate-700">
                    <i class="bi bi-shield-lock-fill text-terracotta mr-1"></i> Role Pengguna
                </label>
                <select
                    name="role"
                    id="role"
                    required
                    class="w-full px-4 py-3 bg-slate-50 border {{ $errors->has('role') ? 'border-red-400' : 'border-slate-200' }} rounded-2xl text-sm font-medium text-slate-900 focus:outline-none focus:border-terracotta transition-colors"
                >
                    <option value="anak" {{ old('role', $user->role) === 'anak' ? 'selected' : '' }}>🧒 Anak / Siswa (10-14 Tahun)</option>
                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>👨‍🏫 Administrator (Control Panel)</option>
                </select>
                @error('role')
                    <p class="text-xs text-red-500 font-medium pl-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password (Optional on Edit) -->
            <div class="space-y-1.5">
                <label for="password" class="block text-xs font-outfit font-bold text-slate-700">
                    <i class="bi bi-key-fill text-terracotta mr-1"></i> Password Baru <span class="text-[10px] text-slate-400 font-normal">(Kosongkan jika tidak ingin mengubah password)</span>
                </label>
                <input
                    type="password"
                    name="password"
                    id="password"
                    placeholder="Masukkan password baru (opsional)"
                    class="w-full px-4 py-3 bg-slate-50 border {{ $errors->has('password') ? 'border-red-400' : 'border-slate-200' }} rounded-2xl text-sm font-medium text-slate-900 focus:outline-none focus:border-terracotta transition-colors"
                >
                @error('password')
                    <p class="text-xs text-red-500 font-medium pl-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="pt-2 flex justify-end gap-3">
                <a href="{{ route('admin.users.index') }}" class="px-5 py-3 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-outfit font-bold text-xs transition-all no-underline">
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
