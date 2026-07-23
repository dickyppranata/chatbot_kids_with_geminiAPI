@extends('layouts.app')

@section('title', 'Jawaban Favorit - AI Buddy')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header Page -->
    <div class="bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200/60 rounded-3xl p-6 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4 animate-fade-in">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-gradient-to-br from-amber-400 to-terracotta rounded-2xl flex items-center justify-center text-white text-3xl shadow-md">
                ⭐
            </div>
            <div>
                <h2 class="font-outfit font-extrabold text-2xl text-slate-900 tracking-tight">
                    Jawaban Favoritku
                </h2>
                <p class="text-sm font-semibold text-slate-500 mt-1">
                    Kumpulan penjelasan paling seru yang pernah kamu simpan dari Kakak AI Tutor! 🧒📚
                </p>
            </div>
        </div>
        <div>
            <a href="/chat" class="px-5 py-3 rounded-full bg-gradient-to-r from-terracotta to-orange-600 hover:from-terracotta-hover hover:to-orange-700 text-white font-outfit font-bold text-xs shadow-md transition-all duration-200 inline-flex items-center gap-2">
                <i class="bi bi-chat-dots-fill"></i>
                <span>Tanya Kakak AI Lagi</span>
            </a>
        </div>
    </div>

    <!-- Error Alert Container -->
    <div id="favoritesError" class="hidden bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-2xl text-sm font-semibold">
        Gagal memuat daftar jawaban favorit.
    </div>

    <!-- Favorites Grid List -->
    <div id="favoritesListContainer" class="space-y-4">
        <!-- Loading State -->
        <div class="text-center py-16 bg-white border border-slate-200/60 rounded-3xl shadow-sm">
            <div class="spinner-border text-terracotta animate-spin inline-block w-8 h-8 border-4 rounded-full" role="status">
                <span class="sr-only"></span>
            </div>
            <p class="text-slate-500 font-bold text-sm mt-3">Membuka lembar favoritmu...</p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const token = localStorage.getItem('access_token');
        if (!token) {
            window.location.href = '/login';
            return;
        }

        loadFavorites();

        async function loadFavorites() {
            const container = document.getElementById('favoritesListContainer');
            const errorAlert = document.getElementById('favoritesError');

            try {
                const res = await fetch('/api/favorites', {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${token}`
                    }
                });

                const result = await res.json();
                if (res.ok && result.status === 'success') {
                    renderFavorites(result.data);
                } else {
                    errorAlert.classList.remove('hidden');
                    container.innerHTML = '';
                }
            } catch (err) {
                errorAlert.classList.remove('hidden');
                container.innerHTML = '';
            }
        }

        function renderFavorites(items) {
            const container = document.getElementById('favoritesListContainer');
            if (items.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-16 bg-white border border-slate-200/60 rounded-3xl shadow-sm p-6 space-y-4">
                        <div class="text-6xl animate-bounce">⭐</div>
                        <h3 class="font-outfit font-extrabold text-lg text-slate-800">Belum ada jawaban favorit</h3>
                        <p class="text-slate-500 text-sm max-w-sm mx-auto font-medium">
                            Ayo belajar dengan Kakak AI Tutor dan simpan jawaban yang paling kamu sukai dengan menekan tombol bintang!
                        </p>
                        <a href="/chat" class="px-5 py-2.5 rounded-full bg-terracotta hover:bg-terracotta-hover text-white font-outfit font-bold text-xs shadow-md transition-all inline-block no-underline">
                            Mulai Bertanya
                        </a>
                    </div>
                `;
                return;
            }

            const topicEmojis = {
                'Matematika Dasar': '🍕',
                'Sains': '🚀',
                'Bahasa': '📚',
                'Pengetahuan Umum': '🌐'
            };

            let html = '';
            items.forEach(item => {
                const emoji = topicEmojis[item.topic_name] || '📖';
                const formattedAnswer = formatMarkdown(item.answer);
                const date = new Date(item.created_at).toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });

                html += `
                    <div class="bg-white border border-slate-200/60 rounded-3xl p-5 shadow-sm space-y-4 hover:shadow-md transition-all duration-200 animate-fade-in" id="fav-card-${item.id}">
                        <!-- Top Header Info -->
                        <div class="flex items-center justify-between flex-wrap gap-2 pb-3 border-b border-slate-100">
                            <div class="flex items-center gap-2">
                                <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-800 text-[10px] font-extrabold uppercase tracking-wider flex items-center gap-1">
                                    <span>${emoji}</span> ${item.topic_name}
                                </span>
                                <span class="text-[11px] text-slate-400 font-semibold">${date}</span>
                            </div>

                            <!-- Unfavorite Button -->
                            <button onclick="unfavoriteItem(${item.id}, ${item.chat_message_id})" class="p-2 rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-500 hover:text-amber-600 transition-colors" title="Hapus dari Favorit">
                                <i class="bi bi-star-fill text-lg"></i>
                            </button>
                        </div>

                        <!-- Question Prompt -->
                        <div class="p-3 bg-amber-50/40 border border-amber-100/50 rounded-2xl text-xs font-semibold text-slate-700 leading-relaxed">
                            <span class="text-terracotta block text-[10px] uppercase font-bold tracking-wider mb-0.5">Pertanyaanmu:</span>
                            "${escapeHtml(item.question)}"
                        </div>

                        <!-- Answer Markdown Text -->
                        <div class="prose prose-slate max-w-none text-sm leading-relaxed text-slate-800 font-medium space-y-2">
                            <span class="text-slate-400 block text-[10px] uppercase font-bold tracking-wider mb-0.5">Jawaban Kakak AI:</span>
                            <div class="pl-2 border-l-2 border-slate-200">${formattedAnswer}</div>
                        </div>

                        <!-- Action Link Button -->
                        <div class="pt-2 flex justify-end">
                            <a href="/chat?session_id=${item.chat_session_id}&highlight_message_id=${item.chat_message_id}" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-terracotta/10 text-slate-700 hover:text-terracotta font-outfit font-bold text-xs transition-all flex items-center gap-1.5 no-underline">
                                <i class="bi bi-arrow-right-short text-base"></i>
                                <span>Buka Percakapan Asal</span>
                            </a>
                        </div>
                    </div>
                `;
            });

            container.innerHTML = html;
        }

        // Action: Unfavorite directly from view
        window.unfavoriteItem = async function(favoriteId, messageId) {
            try {
                const res = await fetch('/api/favorites/toggle', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${token}`
                    },
                    body: JSON.stringify({ chat_message_id: messageId })
                });

                if (res.ok) {
                    const card = document.getElementById(`fav-card-${favoriteId}`);
                    if (card) {
                        card.classList.add('scale-95', 'opacity-0');
                        setTimeout(() => {
                            card.remove();
                            // If empty list, reload list to trigger empty view
                            const list = document.getElementById('favoritesListContainer');
                            if (list.children.length === 0) {
                                loadFavorites();
                            }
                        }, 300);
                    }
                }
            } catch (e) {
                console.error('Failed to remove favorite', e);
            }
        };

        function escapeHtml(str) {
            if (!str) return '';
            return str.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
        }

        function formatMarkdown(text) {
            let formatted = escapeHtml(text);
            formatted = formatted.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
            formatted = formatted.replace(/\n/g, '<br>');
            return formatted;
        }
    });
</script>
@endpush
