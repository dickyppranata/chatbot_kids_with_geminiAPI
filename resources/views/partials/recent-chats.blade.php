<!-- Recent Chats Component (Partials) -->
<div class="bg-white/80 backdrop-blur-md border border-slate-200/60 rounded-3xl p-6 shadow-sm">
    <div class="flex items-center justify-between mb-5">
        <div class="flex items-center gap-2.5">
            <div class="w-9 h-9 rounded-xl bg-terracotta/10 text-terracotta flex items-center justify-center font-bold">
                <i class="bi bi-clock-history text-lg"></i>
            </div>
            <div>
                <h3 class="font-outfit font-extrabold text-base text-slate-900 leading-tight">
                    Riwayat Belajar Terakhir
                </h3>
                <p class="text-xs text-slate-500 font-medium">Lanjutkan percakapan yang belum selesai</p>
            </div>
        </div>
        <a href="/chat" class="text-xs font-outfit font-bold text-terracotta hover:underline flex items-center gap-1 no-underline">
            <span>Lihat Semua</span>
            <i class="bi bi-chevron-right text-[10px]"></i>
        </a>
    </div>

    <!-- Dynamic Container for Recent Sessions -->
    <div id="recentSessionsContainer" class="space-y-2.5">
        <div class="p-4 text-center text-xs text-slate-400 font-medium animate-pulse">
            <i class="bi bi-arrow-repeat animate-spin text-base mr-2 inline-block"></i> Memuat riwayat percakapan...
        </div>
    </div>
</div>

<script>
    async function loadRecentChats() {
        const container = document.getElementById('recentSessionsContainer');
        if (!container) return;

        try {
            const response = await ajaxRequest('/chat/history');
            if (!response) return;

            const result = await response.json();

            if (response.ok && result.status === 'success' && result.data.length > 0) {
                const recentFour = result.data.slice(0, 4);
                container.innerHTML = recentFour.map(session => `
                    <a href="/chat?session_id=${session.id}" class="flex items-center justify-between p-3.5 rounded-2xl bg-slate-50 border border-slate-200/50 hover:bg-slate-100 hover:border-terracotta/30 transition-all group no-underline">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-8 h-8 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center text-sm shrink-0">
                                <i class="bi bi-chat-text-fill"></i>
                            </div>
                            <div class="min-w-0">
                                <p class="font-outfit font-bold text-xs text-slate-900 group-hover:text-terracotta transition-colors truncate">
                                    ${escapeHtml(session.title || 'Percakapan Tanpa Judul')}
                                </p>
                                <span class="text-[10px] text-slate-400 font-semibold flex items-center gap-2 mt-0.5">
                                    <span>${session.messages_count || 0} pesan</span>
                                    <span>•</span>
                                    <span>${new Date(session.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'short' })}</span>
                                </span>
                            </div>
                        </div>
                        <i class="bi bi-arrow-right text-slate-400 group-hover:text-terracotta group-hover:translate-x-1 transition-all text-sm"></i>
                    </a>
                `).join('');
            } else {
                container.innerHTML = `
                    <div class="p-6 text-center text-xs text-slate-400 font-medium">
                        <p class="mb-2">Belum ada percakapan. Mulai tanya Kakak AI sekarang!</p>
                        <a href="/chat" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-terracotta text-white font-bold no-underline hover:bg-terracotta-hover transition-colors">
                            <i class="bi bi-plus-circle"></i> Mulai Chat Baru
                        </a>
                    </div>
                `;
            }
        } catch (e) {
            container.innerHTML = `
                <div class="p-3 text-center text-xs text-slate-400 font-medium">
                    Tidak dapat memuat riwayat.
                </div>
            `;
        }

        function escapeHtml(str) {
            if (!str) return '';
            return str.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
        }
    }

    document.addEventListener('DOMContentLoaded', loadRecentChats);
</script>
