<!-- Sidebar Component (Partials) — Fullstack Session Auth -->
<aside id="appSidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform duration-300 -translate-x-full bg-white/80 backdrop-blur-md border-r border-slate-200/60 flex flex-col justify-between p-4">
    <div class="flex flex-col h-[calc(100vh-100px)]">
        <!-- Logo Header -->
        <div class="flex items-center gap-3 px-2 py-3 mb-6 border-b border-slate-100 shrink-0">
            <div class="w-10 h-10 bg-gradient-to-br from-terracotta to-amber-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-terracotta/20">
                <i class="bi bi-robot text-xl"></i>
            </div>
            <div>
                <h1 class="font-outfit font-extrabold text-lg tracking-tight text-slate-900 leading-none">
                    AI Buddy
                </h1>
                <span class="text-[11px] font-semibold text-terracotta">Tutor Belajar Pintar</span>
            </div>
        </div>

        <!-- Action Button: + Chat Baru -->
        <div class="mb-5 px-1 shrink-0">
            <a href="/chat" class="w-full py-3.5 px-5 rounded-2xl bg-gradient-to-r from-terracotta to-orange-600 hover:from-terracotta-hover hover:to-orange-700 text-white font-outfit font-bold text-sm shadow-lg shadow-terracotta/25 hover:shadow-xl hover:shadow-terracotta/35 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 flex items-center justify-center gap-2.5 no-underline">
                <i class="bi bi-plus-circle-fill text-lg"></i>
                <span>+ Chat Baru</span>
            </a>
        </div>

        <!-- Main Navigation Links -->
        <nav class="space-y-1.5 font-outfit font-semibold text-sm shrink-0">
            <a href="/dashboard" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 {{ request()->is('dashboard') ? 'bg-terracotta/10 text-terracotta font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                <i class="bi bi-grid-1x2-fill text-lg"></i>
                <span>Dashboard</span>
            </a>

            <a href="/chat" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 {{ request()->is('chat*') && !request()->has('session_id') ? 'bg-terracotta/10 text-terracotta font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                <i class="bi bi-chat-dots-fill text-lg"></i>
                <span>Tutor Chat</span>
            </a>

            <a href="/favorites" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 {{ request()->is('favorites*') ? 'bg-terracotta/10 text-terracotta font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                <i class="bi bi-star-fill text-lg"></i>
                <span>Jawaban Favorit</span>
            </a>

            <a href="/profile" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 {{ request()->is('profile*') ? 'bg-terracotta/10 text-terracotta font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                <i class="bi bi-person-fill-gear text-lg"></i>
                <span>Profil Saya</span>
            </a>
        </nav>

        <!-- Divider & Chat History Section Header -->
        <div class="mt-5 mb-2 px-3 flex items-center justify-between text-[11px] font-bold text-slate-400 uppercase tracking-wider shrink-0">
            <span>Riwayat Percakapan</span>
            <i class="bi bi-clock-history"></i>
        </div>

        <!-- Scrollable Chat History List -->
        <div class="flex-1 overflow-y-auto pr-1 space-y-1" id="sidebarChatHistoryList" style="max-height: calc(100vh - 530px);">
            <p class="text-xs text-slate-400 text-center py-4">Memuat riwayat...</p>
        </div>
    </div>

    <!-- Bottom User Profile & Settings -->
    <div class="pt-4 border-t border-slate-100 space-y-2 shrink-0">
        <!-- User Info Badge (Server-Side Rendered via Auth::user()) -->
        <div class="flex items-center justify-between p-2.5 rounded-2xl bg-slate-100/70 border border-slate-200/50">
            <div class="flex items-center gap-2.5 overflow-hidden">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-r from-amber-400 to-terracotta flex items-center justify-center text-white font-bold text-sm shrink-0 shadow-sm">
                    {{ mb_substr(Auth::user()->name ?? 'U', 0, 1) }}
                </div>
                <div class="truncate">
                    <p class="font-outfit font-bold text-xs text-slate-900 truncate">{{ Auth::user()->name ?? 'User' }}</p>
                    <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full bg-amber-100 text-amber-700 uppercase tracking-wider">{{ Auth::user()->role ?? 'anak' }}</span>
                </div>
            </div>

            <!-- Logout Button -->
            <button id="logoutBtn" title="Keluar" class="w-8 h-8 rounded-xl text-slate-400 hover:text-red-500 hover:bg-red-50 flex items-center justify-center transition-colors">
                <i class="bi bi-box-arrow-right text-base"></i>
            </button>
        </div>

        <!-- Hidden Logout Form (CSRF Protected) -->
        <form id="logoutForm" action="/logout" method="POST" class="hidden">
            @csrf
        </form>

        <a href="/" class="block text-center text-xs font-semibold text-slate-400 hover:text-terracotta transition-colors py-1">
            <i class="bi bi-house-door-fill mr-1"></i> Beranda Utama
        </a>
    </div>
</aside>

<!-- JavaScript for Sidebar Chat History (Fullstack — CSRF Session Auth) -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Load Sidebar History on init
        fetchSidebarHistory();

        // Listen for custom events to refresh history
        window.addEventListener('refreshSidebarHistory', fetchSidebarHistory);

        async function fetchSidebarHistory() {
            const container = document.getElementById('sidebarChatHistoryList');
            if (!container) return;

            try {
                const res = await ajaxRequest('/chat/history');
                if (!res) return;
                const result = await res.json();

                if (res.ok && result.status === 'success') {
                    renderSidebarHistory(result.data);
                } else {
                    container.innerHTML = `<p class="text-xs text-slate-400 text-center py-4">Gagal memuat riwayat.</p>`;
                }
            } catch (err) {
                container.innerHTML = `<p class="text-xs text-slate-400 text-center py-4">Masalah koneksi.</p>`;
            }
        }

        function renderSidebarHistory(sessions) {
            const container = document.getElementById('sidebarChatHistoryList');
            if (sessions.length === 0) {
                container.innerHTML = `<p class="text-xs text-slate-400 text-center py-6">Belum ada percakapan.</p>`;
                return;
            }

            const urlParams = new URLSearchParams(window.location.search);
            const activeSessionId = urlParams.get('session_id') ? parseInt(urlParams.get('session_id')) : null;

            const topicEmojis = {
                'Matematika': '🍕',
                'Sains / IPA': '🚀',
                'Bahasa Indonesia': '📚',
                'Pengetahuan Umum': '🌐'
            };

            let html = '';
            sessions.forEach(session => {
                const emoji = session.topic ? (topicEmojis[session.topic.name] || '📖') : '💬';
                const isActive = activeSessionId === session.id;

                html += `
                    <div class="group flex items-center justify-between px-3 py-2 rounded-xl text-[13px] font-medium text-slate-700 hover:bg-slate-100 hover:text-slate-900 transition-all duration-150 cursor-pointer relative ${isActive ? 'bg-terracotta/10 text-terracotta font-bold border-l-4 border-terracotta rounded-l-none' : ''}"
                         onclick="window.location.href='/chat?session_id=${session.id}'">
                        <div class="flex items-center gap-2 overflow-hidden w-[75%]">
                            <span class="shrink-0 text-sm">${emoji}</span>
                            <span class="truncate block">${escapeHtml(session.title || 'Percakapan Tutor')}</span>
                        </div>

                        <div class="flex items-center gap-1 shrink-0 ${session.is_pinned ? '' : 'opacity-0 group-hover:opacity-100 transition-opacity duration-150'}">
                            <button onclick="event.stopPropagation(); togglePinSession(${session.id})" class="p-0.5 text-slate-400 hover:text-terracotta rounded transition-colors" title="${session.is_pinned ? 'Lepas Sematan' : 'Sematkan Ke Paling Atas'}">
                                <i class="bi ${session.is_pinned ? 'bi-pin-fill text-terracotta' : 'bi-pin-angle'}"></i>
                            </button>
                            <button onclick="event.stopPropagation(); renameSessionPrompt(${session.id}, '${escapeQuote(session.title)}')" class="p-0.5 text-slate-400 hover:text-terracotta rounded transition-colors" title="Ubah Judul">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button onclick="event.stopPropagation(); deleteSessionConfirm(${session.id})" class="p-0.5 text-slate-400 hover:text-red-500 rounded transition-colors" title="Hapus Chat">
                                <i class="bi bi-trash3-fill"></i>
                            </button>
                        </div>
                    </div>
                `;
            });

            container.innerHTML = html;
        }

        // Action: Pin / Unpin
        window.togglePinSession = async function(id) {
            try {
                const res = await ajaxRequest(`/chat/history/${id}/pin`, { method: 'POST' });
                if (res && res.ok) fetchSidebarHistory();
            } catch (e) {
                console.error('Failed to pin session', e);
            }
        };

        // Action: Rename
        window.renameSessionPrompt = async function(id, currentTitle) {
            const newTitle = prompt('Masukkan nama/judul percakapan baru:', currentTitle);
            if (newTitle === null) return;
            const trimmed = newTitle.trim();
            if (!trimmed) { alert('Judul tidak boleh kosong!'); return; }

            try {
                const res = await ajaxRequest(`/chat/history/${id}`, {
                    method: 'PUT',
                    body: JSON.stringify({ title: trimmed })
                });

                if (res && res.ok) {
                    fetchSidebarHistory();
                    const urlParams = new URLSearchParams(window.location.search);
                    const activeSessionId = urlParams.get('session_id') ? parseInt(urlParams.get('session_id')) : null;
                    if (activeSessionId === id) {
                        const titleEl = document.getElementById('chatSessionTitle');
                        if (titleEl) titleEl.textContent = trimmed;
                    }
                } else if (res) {
                    const data = await res.json();
                    alert(data.message || 'Gagal mengubah judul.');
                }
            } catch (e) {
                alert('Terjadi kesalahan jaringan.');
            }
        };

        // Action: Delete
        window.deleteSessionConfirm = async function(id) {
            if (!confirm('Apakah kamu yakin ingin menghapus riwayat percakapan ini beserta seluruh pesannya?')) return;

            try {
                const res = await ajaxRequest(`/chat/history/${id}`, { method: 'DELETE' });

                if (res && res.ok) {
                    fetchSidebarHistory();
                    const urlParams = new URLSearchParams(window.location.search);
                    const activeSessionId = urlParams.get('session_id') ? parseInt(urlParams.get('session_id')) : null;
                    if (activeSessionId === id) window.location.href = '/chat';
                } else {
                    alert('Gagal menghapus percakapan.');
                }
            } catch (e) {
                alert('Terjadi kesalahan jaringan.');
            }
        };

        function escapeHtml(str) {
            if (!str) return '';
            return str.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
        }

        function escapeQuote(str) {
            if (!str) return '';
            return str.replace(/'/g, "\\'");
        }
    });
</script>
