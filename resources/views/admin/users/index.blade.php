@extends('layouts.admin')

@section('title', 'Manajemen Pengguna - AI Buddy Admin')
@section('page_heading', 'Manajemen Pengguna')
@section('page_subheading', 'Kelola seluruh daftar akun siswa (10-14th) dan administrator platform')

@section('content')
<div class="space-y-6 animate-fade-in">

    <!-- Header Action & Search Bar -->
    <div class="bg-white border border-slate-200/80 rounded-3xl p-5 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="font-outfit font-extrabold text-xl text-slate-900 flex items-center gap-2">
                <i class="bi bi-people-fill text-terracotta"></i> Daftar Pengguna Sistem
            </h2>
            <p class="text-xs text-slate-500 font-medium mt-0.5">
                Total {{ $users->total() }} akun terdaftar dalam basis data
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.users.create') }}" class="px-5 py-2.5 rounded-2xl bg-gradient-to-r from-terracotta to-orange-600 hover:from-terracotta-hover hover:to-orange-700 text-white font-outfit font-bold text-xs shadow-md shadow-terracotta/20 hover:shadow-lg transition-all no-underline inline-flex items-center gap-2">
                <i class="bi bi-person-plus-fill text-sm"></i>
                <span>+ Tambah Pengguna Baru</span>
            </a>
        </div>
    </div>

    <!-- Alert Notifications -->
    @if(session('success'))
        <div class="px-4 py-3 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-medium flex items-center gap-2 shadow-sm">
            <i class="bi bi-check-circle-fill text-emerald-500"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="px-4 py-3 rounded-2xl bg-red-50 border border-red-200 text-red-700 text-sm font-medium flex items-center gap-2 shadow-sm">
            <i class="bi bi-exclamation-triangle-fill text-red-500"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Filter & Search Form -->
    <div class="bg-white border border-slate-200/80 rounded-3xl p-4 shadow-sm">
        <form method="GET" action="{{ route('admin.users.index') }}" class="grid md:grid-cols-12 gap-3 items-center">
            <!-- Search input -->
            <div class="md:col-span-6 relative">
                <i class="bi bi-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari berdasarkan nama atau email..."
                    class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-medium text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-terracotta transition-colors"
                >
            </div>

            <!-- Role filter -->
            <div class="md:col-span-4">
                <select name="role" onchange="this.form.submit()" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-medium text-slate-900 focus:outline-none focus:border-terracotta transition-colors">
                    <option value="">Semua Role (Anak & Admin)</option>
                    <option value="anak" {{ request('role') === 'anak' ? 'selected' : '' }}>Role: Anak (Siswa 10-14th)</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Role: Administrator</option>
                </select>
            </div>

            <!-- Submit & Reset buttons -->
            <div class="md:col-span-2 flex items-center gap-2">
                <button type="submit" class="w-full py-2.5 rounded-2xl bg-slate-900 hover:bg-slate-800 text-white font-outfit font-bold text-xs shadow-sm transition-all">
                    Cari
                </button>
                @if(request('search') || request('role'))
                    <a href="{{ route('admin.users.index') }}" class="px-3 py-2.5 rounded-2xl bg-slate-100 text-slate-600 hover:bg-slate-200 font-bold text-xs no-underline" title="Reset Filter">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Users Table Card -->
    <div class="bg-white border border-slate-200/80 rounded-3xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs font-medium">
                <thead class="bg-slate-50 border-b border-slate-200/80 text-slate-500 font-bold uppercase tracking-wider">
                    <tr>
                        <th class="p-4">Pengguna</th>
                        <th class="p-4">Role</th>
                        <th class="p-4">Aktivitas Chat</th>
                        <th class="p-4">Terdaftar</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <!-- User Info -->
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-2xl {{ $user->isAdmin() ? 'bg-gradient-to-br from-red-500 to-terracotta' : 'bg-gradient-to-br from-amber-400 to-terracotta' }} flex items-center justify-center text-white font-bold text-sm shadow-sm shrink-0">
                                        {{ mb_substr($user->name, 0, 1) }}
                                    </div>
                                    <div class="truncate">
                                        <p class="font-outfit font-bold text-sm text-slate-900 truncate">
                                            {{ $user->name }}
                                            @if(Auth::id() === $user->id)
                                                <span class="text-[10px] font-bold text-terracotta ml-1">(Anda)</span>
                                            @endif
                                        </p>
                                        <p class="text-xs text-slate-400 font-medium truncate">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>

                            <!-- Role Badge -->
                            <td class="p-4">
                                @if($user->isAdmin())
                                    <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-[10px] font-extrabold uppercase tracking-wider inline-flex items-center gap-1">
                                        <i class="bi bi-shield-lock-fill"></i> Admin
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-800 text-[10px] font-extrabold uppercase tracking-wider inline-flex items-center gap-1">
                                        🧒 Siswa (Anak)
                                    </span>
                                @endif
                            </td>

                            <!-- Activity Chat Stats -->
                            <td class="p-4">
                                <span class="font-bold text-slate-800 text-xs">
                                    {{ $user->chat_sessions_count }} Sesi Percakapan
                                </span>
                            </td>

                            <!-- Registered Date -->
                            <td class="p-4 text-slate-500 font-medium">
                                {{ $user->created_at->locale('id')->isoFormat('D MMMM Y') }}
                            </td>

                            <!-- Actions -->
                            <td class="p-4 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <!-- Edit Button -->
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="p-2 rounded-xl bg-slate-100 hover:bg-terracotta hover:text-white text-slate-600 transition-colors no-underline" title="Edit Pengguna">
                                        <i class="bi bi-pencil-square text-sm"></i>
                                    </a>

                                    <!-- Delete Button -->
                                    @if(Auth::id() !== $user->id)
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna {{ e($user->name) }}? Seluruh riwayat chat pengguna ini akan terhapus!');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 rounded-xl bg-slate-100 hover:bg-red-500 hover:text-white text-slate-600 transition-colors" title="Hapus Pengguna">
                                                <i class="bi bi-trash3-fill text-sm"></i>
                                            </button>
                                        </form>
                                    @else
                                        <button disabled class="p-2 rounded-xl bg-slate-100 text-slate-300 cursor-not-allowed" title="Tidak dapat menghapus akun sendiri">
                                            <i class="bi bi-trash3-fill text-sm"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-slate-400 font-medium">
                                <div class="text-4xl mb-2">🔍</div>
                                <p>Tidak ditemukan data pengguna yang sesuai.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        @if($users->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $users->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
