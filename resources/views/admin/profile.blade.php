@extends('layouts.admin')

@section('title', 'Profil Admin - AI Buddy')
@section('page_heading', 'Profil Saya (Administrator)')
@section('page_subheading', 'Kelola informasi pribadi dan kata sandi akun administrator sistem')

@section('content')
<div class="max-w-4xl mx-auto space-y-6 animate-fade-in">

    <!-- Alert Success Notification -->
    @if(session('success'))
        <div class="px-4 py-3 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-medium flex items-center gap-2 shadow-sm">
            <i class="bi bi-check-circle-fill text-emerald-500"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Profile Summary Header Card -->
    <div class="bg-white border border-slate-200/80 rounded-3xl p-6 md:p-8 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-terracotta to-amber-500 text-white font-black text-2xl flex items-center justify-center shadow-lg shadow-terracotta/20 shrink-0">
                👨‍🏫
            </div>
            <div>
                <div class="flex items-center gap-2">
                    <h2 class="font-outfit font-extrabold text-2xl text-slate-900 leading-tight">
                        {{ $user->name }}
                    </h2>
                    <span class="px-2.5 py-0.5 rounded-full bg-red-100 text-red-700 text-[10px] font-black uppercase tracking-wider">
                        ADMIN
                    </span>
                </div>
                <p class="text-xs text-slate-500 font-medium mt-1">
                    {{ $user->email }} • Terdaftar sejak {{ $user->created_at->locale('id')->isoFormat('D MMMM Y') }}
                </p>
            </div>
        </div>

        <div class="px-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-semibold text-slate-600 space-y-0.5">
            <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Status Akses</span>
            <span class="text-emerald-600 font-bold flex items-center gap-1">
                <i class="bi bi-shield-check text-sm"></i> Full Control Panel Admin
            </span>
        </div>
    </div>

    <!-- 2 Forms Grid: Account Details & Password Change -->
    <div class="grid md:grid-cols-2 gap-6">

        <!-- Form 1: Edit Information -->
        <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm space-y-5">
            <div class="flex items-center gap-3 pb-3 border-b border-slate-100">
                <div class="w-10 h-10 rounded-2xl bg-amber-100 text-terracotta flex items-center justify-center text-lg font-bold">
                    <i class="bi bi-person-lines-fill"></i>
                </div>
                <div>
                    <h3 class="font-outfit font-extrabold text-base text-slate-900">Informasi Pribadi</h3>
                    <p class="text-[11px] text-slate-500 font-medium">Perbarui nama dan alamat email akun admin Anda.</p>
                </div>
            </div>

            <form action="{{ route('admin.profile.update') }}" method="POST" class="space-y-4">
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
                        class="w-full px-4 py-2.5 bg-slate-50 border {{ $errors->has('name') ? 'border-red-400' : 'border-slate-200' }} rounded-2xl text-xs font-medium text-slate-900 focus:outline-none focus:border-terracotta transition-colors"
                    >
                    @error('name')
                        <p class="text-[11px] text-red-500 font-medium pl-1">{{ $message }}</p>
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
                        class="w-full px-4 py-2.5 bg-slate-50 border {{ $errors->has('email') ? 'border-red-400' : 'border-slate-200' }} rounded-2xl text-xs font-medium text-slate-900 focus:outline-none focus:border-terracotta transition-colors"
                    >
                    @error('email')
                        <p class="text-[11px] text-red-500 font-medium pl-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Role (Disabled) -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-outfit font-bold text-slate-400">
                        <i class="bi bi-shield-lock-fill mr-1"></i> Peran Sistem
                    </label>
                    <input
                        type="text"
                        disabled
                        value="Administrator System"
                        class="w-full px-4 py-2.5 bg-slate-100 border border-slate-200 rounded-2xl text-xs font-bold text-slate-500 cursor-not-allowed"
                    >
                </div>

                <!-- Submit Button -->
                <div class="pt-2 flex justify-end">
                    <button
                        type="submit"
                        class="px-5 py-2.5 rounded-2xl bg-gradient-to-r from-terracotta to-orange-600 hover:from-terracotta-hover hover:to-orange-700 text-white font-outfit font-bold text-xs shadow-md transition-all flex items-center gap-1.5"
                    >
                        <i class="bi bi-floppy-fill"></i>
                        <span>Simpan Profil</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Form 2: Change Password -->
        <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm space-y-5">
            <div class="flex items-center gap-3 pb-3 border-b border-slate-100">
                <div class="w-10 h-10 rounded-2xl bg-purple-100 text-purple-600 flex items-center justify-center text-lg font-bold">
                    <i class="bi bi-key-fill"></i>
                </div>
                <div>
                    <h3 class="font-outfit font-extrabold text-base text-slate-900">Ubah Kata Sandi</h3>
                    <p class="text-[11px] text-slate-500 font-medium">Perbarui password untuk menjaga keamanan akun admin.</p>
                </div>
            </div>

            <form action="{{ route('admin.profile.password') }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <!-- Current Password -->
                <div class="space-y-1.5">
                    <label for="current_password" class="block text-xs font-outfit font-bold text-slate-700">
                        Password Saat Ini
                    </label>
                    <input
                        type="password"
                        name="current_password"
                        id="current_password"
                        required
                        placeholder="••••••••"
                        class="w-full px-4 py-2.5 bg-slate-50 border {{ $errors->has('current_password') ? 'border-red-400' : 'border-slate-200' }} rounded-2xl text-xs font-medium text-slate-900 focus:outline-none focus:border-terracotta transition-colors"
                    >
                    @error('current_password')
                        <p class="text-[11px] text-red-500 font-medium pl-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- New Password -->
                <div class="space-y-1.5">
                    <label for="password" class="block text-xs font-outfit font-bold text-slate-700">
                        Password Baru
                    </label>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        required
                        placeholder="Minimal 6 karakter"
                        class="w-full px-4 py-2.5 bg-slate-50 border {{ $errors->has('password') ? 'border-red-400' : 'border-slate-200' }} rounded-2xl text-xs font-medium text-slate-900 focus:outline-none focus:border-terracotta transition-colors"
                    >
                    @error('password')
                        <p class="text-[11px] text-red-500 font-medium pl-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm New Password -->
                <div class="space-y-1.5">
                    <label for="password_confirmation" class="block text-xs font-outfit font-bold text-slate-700">
                        Konfirmasi Password Baru
                    </label>
                    <input
                        type="password"
                        name="password_confirmation"
                        id="password_confirmation"
                        required
                        placeholder="Ulangi password baru"
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-medium text-slate-900 focus:outline-none focus:border-terracotta transition-colors"
                    >
                </div>

                <!-- Submit Button -->
                <div class="pt-2 flex justify-end">
                    <button
                        type="submit"
                        class="px-5 py-2.5 rounded-2xl bg-slate-900 hover:bg-slate-800 text-white font-outfit font-bold text-xs shadow-md transition-all flex items-center gap-1.5"
                    >
                        <i class="bi bi-shield-lock-fill"></i>
                        <span>Ubah Password</span>
                    </button>
                </div>
            </form>
        </div>

    </div>

</div>
@endsection
