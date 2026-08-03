@extends('layouts.admin')

@section('title', 'Transkrip Chat ' . $user->name . ' - AI Buddy Admin')
@section('page_heading', 'Riwayat Percakapan: ' . $user->name)
@section('page_subheading', 'Memantau seluruh sesi percakapan dan transkrip interaksi siswa dengan AI Tutor')

@section('content')
<div class="space-y-6 animate-fade-in">

    <!-- Header Action Bar -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.chat-history.index') }}" class="px-4 py-2 rounded-2xl bg-white border border-slate-200 text-slate-700 font-outfit font-bold text-xs hover:bg-slate-50 transition-all no-underline shadow-sm inline-flex items-center gap-1.5">
            <i class="bi bi-arrow-left text-sm"></i>
            <span>Kembali ke Pengelompokan Siswa</span>
        </a>
    </div>

    <!-- Alert Notifications -->
    @if(session('success'))
        <div class="px-4 py-3 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-medium flex items-center gap-2 shadow-sm">
            <i class="bi bi-check-circle-fill text-emerald-500"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Student Profile Header Card -->
    <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-400 to-terracotta text-white font-black text-xl flex items-center justify-center shadow-md shrink-0">
                {{ strtoupper(substr($user->name, 0, 2)) }}
            </div>
            <div>
                <h2 class="font-outfit font-extrabold text-xl text-slate-900 leading-tight">
                    {{ $user->name }}
                </h2>
                <p class="text-xs text-slate-500 font-medium mt-0.5">
                    {{ $user->email }} • Terdaftar sejak {{ $user->created_at->locale('id')->isoFormat('D MMMM Y') }}
                </p>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <span class="px-3.5 py-1.5 rounded-full bg-purple-100 text-purple-800 text-xs font-bold">
                {{ $sessions->count() }} Sesi Chat Tersimpan
            </span>
        </div>
    </div>

    <!-- Main 2-Column Interface: Sessions Sidebar vs Active Chat Transcript -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- Left Column: Sessions List for this Student (4 cols) -->
        <div class="lg:col-span-4 space-y-3">
            <div class="bg-white border border-slate-200/80 rounded-3xl p-4 shadow-sm">
                <h3 class="font-outfit font-extrabold text-sm text-slate-900 pb-3 border-b border-slate-100 flex items-center justify-between">
                    <span><i class="bi bi-journals text-terracotta mr-1.5"></i> Sesi Percakapan</span>
                    <span class="text-[10px] font-bold text-slate-400">({{ $sessions->count() }})</span>
                </h3>

                <div class="mt-3 space-y-2 max-h-[600px] overflow-y-auto pr-1 scrollbar-none">
                    @forelse($sessions as $session)
                        @php $isActive = $activeSession && $activeSession->id == $session->id; @endphp
                        <div class="group relative rounded-2xl p-3.5 border transition-all duration-200 {{ $isActive ? 'bg-amber-50/80 border-terracotta shadow-sm' : 'bg-slate-50/70 border-slate-200/70 hover:bg-slate-100' }}">
                            <a href="{{ route('admin.chat-history.show', ['user' => $user->id, 'session_id' => $session->id]) }}" class="block no-underline space-y-1.5">
                                <div class="flex items-center justify-between">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">
                                        📚 {{ $session->topic->name ?? 'Topik' }}
                                    </span>
                                    @if($session->is_pinned)
                                        <span class="text-[10px] font-bold text-amber-600 flex items-center gap-1">
                                            <i class="bi bi-pin-angle-fill"></i> Dipin
                                        </span>
                                    @endif
                                </div>

                                <h4 class="font-outfit font-bold text-xs text-slate-900 group-hover:text-terracotta transition-colors line-clamp-1">
                                    {{ $session->title }}
                                </h4>

                                <div class="flex items-center justify-between text-[10px] text-slate-400 font-medium pt-1 border-t border-slate-200/40">
                                    <span>{{ $session->messages_count }} pesan</span>
                                    <span>{{ $session->updated_at->diffForHumans() }}</span>
                                </div>
                            </a>

                            <!-- Delete Session Button -->
                            <form action="{{ route('admin.chat-history.destroy-session', $session->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus sesi percakapan ini?');" class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1 rounded-lg bg-white border border-slate-200 text-slate-400 hover:text-red-500 hover:border-red-200 shadow-sm text-xs" title="Hapus Sesi Ini">
                                    <i class="bi bi-trash3-fill"></i>
                                </button>
                            </form>
                        </div>
                    @empty
                        <div class="p-6 text-center text-slate-400 text-xs italic">
                            Siswa ini belum memiliki sesi percakapan.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right Column: Active Chat Transcript (8 cols) -->
        <div class="lg:col-span-8">
            @if($activeSession)
                <div class="bg-white border border-slate-200/80 rounded-3xl shadow-sm overflow-hidden flex flex-col h-[650px]">

                    <!-- Active Session Header -->
                    <div class="p-5 border-b border-slate-100 bg-slate-50/60 flex items-center justify-between shrink-0">
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">
                                    📚 {{ $activeSession->topic->name ?? 'Topik Pelajaran' }}
                                </span>
                                <span class="text-[10px] font-semibold text-slate-400">
                                    ID Sesi #{{ $activeSession->id }}
                                </span>
                            </div>
                            <h3 class="font-outfit font-extrabold text-base text-slate-900 mt-1">
                                {{ $activeSession->title }}
                            </h3>
                        </div>

                        <div class="text-right">
                            <span class="text-[11px] font-medium text-slate-500 block">
                                Mulai: {{ $activeSession->created_at->locale('id')->isoFormat('D MMM Y, HH:mm') }}
                            </span>
                            <span class="text-[10px] font-bold text-slate-400">
                                Total {{ $activeSession->messages->count() }} pesan
                            </span>
                        </div>
                    </div>

                    <!-- Chat Transcript Bubbles Area -->
                    <div class="p-6 overflow-y-auto flex-1 space-y-4 bg-slate-50/30">
                        @forelse($activeSession->messages as $msg)
                            @if($msg->sender_type === 'user')
                                <!-- Student Message Bubble (Right Aligned) -->
                                <div class="flex justify-end">
                                    <div class="max-w-lg space-y-1">
                                        <div class="flex items-center justify-end gap-1.5 text-[10px] text-slate-400 font-medium">
                                            <span>{{ $user->name }}</span>
                                            <span>•</span>
                                            <span>{{ $msg->created_at->format('H:i') }}</span>
                                        </div>
                                        <div class="p-4 rounded-3xl rounded-tr-sm bg-gradient-to-r from-terracotta to-orange-600 text-white font-medium text-xs leading-relaxed shadow-sm">
                                            {{ $msg->message }}
                                        </div>
                                    </div>
                                </div>
                            @else
                                <!-- AI Tutor Response Bubble (Left Aligned) -->
                                <div class="flex items-start gap-3">
                                    <div class="w-8 h-8 rounded-2xl bg-gradient-to-br from-amber-400 to-terracotta text-white flex items-center justify-center text-sm font-bold shrink-0 shadow-md">
                                        🤖
                                    </div>
                                    <div class="max-w-xl space-y-1">
                                        <div class="flex items-center gap-1.5 text-[10px] text-slate-400 font-medium">
                                            <span class="font-bold text-slate-700">Kakak AI Tutor</span>
                                            <span>•</span>
                                            <span>{{ $msg->created_at->format('H:i') }}</span>
                                        </div>
                                        <div class="p-4 rounded-3xl rounded-tl-sm bg-white border border-slate-200/80 text-slate-800 font-medium text-xs leading-relaxed shadow-sm whitespace-pre-line">
                                            {{ $msg->message }}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @empty
                            <div class="p-8 text-center text-slate-400 text-xs italic">
                                Belum ada pesan dalam sesi percakapan ini.
                            </div>
                        @endforelse
                    </div>

                    <!-- Footer Info (Read-Only Warning) -->
                    <div class="p-3 bg-slate-50 border-t border-slate-100 text-center text-[11px] font-medium text-slate-400 shrink-0 flex items-center justify-center gap-1.5">
                        <i class="bi bi-shield-check text-emerald-500"></i>
                        <span>Modul Pemantauan Admin (Hanya Baca) — Transkrip percakapan siswa dan AI Tutor</span>
                    </div>

                </div>
            @else
                <div class="bg-white border border-slate-200/80 rounded-3xl p-12 text-center text-slate-400 space-y-3">
                    <div class="text-4xl">💬</div>
                    <h3 class="font-outfit font-bold text-slate-700 text-base">Pilih Sesi Percakapan</h3>
                    <p class="text-xs max-w-sm mx-auto">Silakan pilih salah satu sesi percakapan pada daftar di sebelah kiri untuk menampilkan transkrip obrolan lengkap.</p>
                </div>
            @endif
        </div>

    </div>

</div>
@endsection
