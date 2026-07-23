@extends('layouts.app')

@section('title', 'Profil Saya - AI Buddy')

@section('content')
<div class="max-w-4xl mx-auto space-y-6 animate-fade-in">
    <!-- Header Page -->
    <div class="bg-gradient-to-r from-terracotta/10 via-amber-500/10 to-transparent border border-terracotta/20 rounded-3xl p-6 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 bg-gradient-to-br from-terracotta to-amber-500 rounded-2xl flex items-center justify-center text-white text-3xl shadow-md font-extrabold font-outfit">
                {{ mb_substr($user->name, 0, 1) }}
            </div>
            <div>
                <h2 class="font-outfit font-extrabold text-2xl text-slate-900 tracking-tight">
                    Pengaturan Profil
                </h2>
                <p class="text-sm font-semibold text-slate-500 mt-1">
                    Kelola informasi akun dan kata sandi belajarmu di sini.
                </p>
            </div>
        </div>
        <div>
            <span class="px-4 py-2 rounded-full bg-amber-100 text-amber-800 text-xs font-bold uppercase tracking-wider">
                Role: {{ $user->role ?? 'anak' }}
            </span>
        </div>
    </div>

    <!-- Alert Notifications -->
    @if(session('success'))
        <div class="px-4 py-3 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-medium flex items-center gap-2">
            <i class="bi bi-check-circle-fill text-emerald-500"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="px-4 py-3 rounded-2xl bg-red-50 border border-red-200 text-red-700 text-sm font-medium flex items-center gap-2">
            <i class="bi bi-exclamation-triangle-fill text-red-500"></i>
            <span>{{ $errors->first() }}</span>
        </div>
    @endif

    <div class="grid md:grid-cols-2 gap-6">
        <!-- 1. Edit Profile Form -->
        <div class="bg-white border border-slate-200/60 rounded-3xl p-6 shadow-sm space-y-4">
            <div class="flex items-center gap-2 pb-3 border-b border-slate-100">
                <i class="bi bi-person-gear text-terracotta text-xl"></i>
                <h3 class="font-outfit font-extrabold text-lg text-slate-900">Informasi Pengguna</h3>
            </div>

            <form action="/profile" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="space-y-1.5">
                    <label for="name" class="block text-xs font-outfit font-bold text-slate-700">Nama Lengkap</label>
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

                <div class="space-y-1.5">
                    <label for="email" class="block text-xs font-outfit font-bold text-slate-700">Alamat Email</label>
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

                <button
                    type="submit"
                    class="w-full py-3 rounded-2xl bg-terracotta hover:bg-terracotta-hover text-white font-outfit font-bold text-xs shadow-md transition-all duration-200 flex items-center justify-center gap-2"
                >
                    <i class="bi bi-floppy-fill"></i>
                    <span>Simpan Perubahan</span>
                </button>
            </form>
        </div>

        <!-- 2. Change Password Form -->
        <div class="bg-white border border-slate-200/60 rounded-3xl p-6 shadow-sm space-y-4">
            <div class="flex items-center gap-2 pb-3 border-b border-slate-100">
                <i class="bi bi-shield-lock-fill text-amber-500 text-xl"></i>
                <h3 class="font-outfit font-extrabold text-lg text-slate-900">Ubah Password</h3>
            </div>

            <form action="/profile/password" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="space-y-1.5">
                    <label for="current_password" class="block text-xs font-outfit font-bold text-slate-700">Password Saat Ini</label>
                    <input
                        type="password"
                        name="current_password"
                        id="current_password"
                        required
                        class="w-full px-4 py-3 bg-slate-50 border {{ $errors->has('current_password') ? 'border-red-400' : 'border-slate-200' }} rounded-2xl text-sm font-medium text-slate-900 focus:outline-none focus:border-terracotta transition-colors"
                    >
                    @error('current_password')
                        <p class="text-xs text-red-500 font-medium pl-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1.5">
                    <label for="password" class="block text-xs font-outfit font-bold text-slate-700">Password Baru</label>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        required
                        placeholder="Minimal 6 karakter"
                        class="w-full px-4 py-3 bg-slate-50 border {{ $errors->has('password') ? 'border-red-400' : 'border-slate-200' }} rounded-2xl text-sm font-medium text-slate-900 focus:outline-none focus:border-terracotta transition-colors"
                    >
                    @error('password')
                        <p class="text-xs text-red-500 font-medium pl-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1.5">
                    <label for="password_confirmation" class="block text-xs font-outfit font-bold text-slate-700">Konfirmasi Password Baru</label>
                    <input
                        type="password"
                        name="password_confirmation"
                        id="password_confirmation"
                        required
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium text-slate-900 focus:outline-none focus:border-terracotta transition-colors"
                    >
                </div>

                <button
                    type="submit"
                    class="w-full py-3 rounded-2xl bg-slate-800 hover:bg-slate-900 text-white font-outfit font-bold text-xs shadow-md transition-all duration-200 flex items-center justify-center gap-2"
                >
                    <i class="bi bi-key-fill"></i>
                    <span>Ubah Password</span>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
