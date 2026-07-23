@extends('layouts.app')

@section('title', 'Tutor Chat - AI Buddy')

@section('content')
<div class="flex flex-col h-[calc(100vh-100px)] md:h-[calc(100vh-90px)] max-w-5xl mx-auto">

    <!-- Top Workspace Header Bar -->
    <div class="bg-white/80 backdrop-blur-md border border-slate-200/60 rounded-3xl p-4 mb-3 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-3">
        <div class="flex items-center gap-3 overflow-hidden">
            <a href="/dashboard" class="w-9 h-9 rounded-2xl bg-slate-100 border border-slate-200 text-slate-600 hover:text-terracotta hover:bg-amber-50 flex items-center justify-center transition-colors shrink-0 no-underline" title="Kembali ke Dashboard">
                <i class="bi bi-arrow-left text-lg"></i>
            </a>

            <div class="w-10 h-10 bg-gradient-to-br from-terracotta to-amber-500 rounded-2xl flex items-center justify-center text-white font-bold text-xl shrink-0 shadow-md shadow-terracotta/20" id="chatTopicIcon">
                🤖
            </div>

            <div class="truncate">
                <div class="flex items-center gap-2">
                    <h1 class="font-outfit font-extrabold text-base md:text-lg text-slate-900 truncate" id="chatSessionTitle">
                        Tutor Belajar Interaktif
                    </h1>
                    <span id="topicBadge" class="hidden px-2.5 py-0.5 rounded-full bg-amber-100 text-terracotta font-outfit font-bold text-[11px] shrink-0">
                        Umum
                    </span>
                </div>
                <p class="text-xs text-slate-500 font-medium truncate" id="chatSessionSubtitle">
                    Pilih topik belajar di bawah untuk mulai berdiskusi bersama Kakak AI
                </p>
            </div>
        </div>

        <!-- Topic Selector Pills (Dynamic from Eloquent ORM API) -->
        <div class="flex items-center gap-1.5 overflow-x-auto pb-1 md:pb-0 scrollbar-none" id="topicSelectorPills">
            <button onclick="selectTopic(null)" class="topic-pill active px-3 py-1.5 rounded-full text-xs font-bold transition-all border shrink-0 bg-terracotta text-white border-terracotta" data-topic-id="all">
                💬 Umum
            </button>
            <!-- Dynamically populated from /api/topics -->
        </div>
    </div>

    <!-- Main Chat Feed Area -->
    <div class="flex-1 bg-white/70 backdrop-blur-md border border-slate-200/60 rounded-3xl p-4 md:p-6 shadow-sm overflow-y-auto space-y-4 font-medium text-sm scroll-smooth" id="chatFeed">

        <!-- Welcome Greeting Banner (Default) -->
        <div id="welcomeBanner" class="py-8 px-6 text-center max-w-xl mx-auto space-y-4 animate-fade-in">
            <div class="w-16 h-16 bg-amber-100 rounded-3xl flex items-center justify-center text-4xl mx-auto shadow-inner" id="welcomeEmoji">
                👋
            </div>
            <h2 class="font-outfit font-extrabold text-2xl text-slate-900" id="welcomeTitle">
                Halo, Adik Pintar!
            </h2>
            <p class="text-slate-600 text-sm leading-relaxed" id="welcomeDesc">
                Aku adalah <b>Kakak AI Tutor</b> dari <b>AI Buddy</b>. Pilih topik di atas atau klik salah satu saran pertanyaan dari database di bawah ini:
            </p>

            <!-- Sample Prompt Chips (Loaded from ExamplePrompts table via Eloquent) -->
            <div class="pt-2">
                <p class="text-xs font-bold text-terracotta uppercase tracking-wider mb-3 flex items-center justify-center gap-1.5">
                    <i class="bi bi-stars"></i> Saran Pertanyaan Topik (Database):
                </p>
                <div class="flex flex-wrap justify-center gap-2" id="samplePromptChips">
                    <div class="text-slate-400 text-xs font-medium py-2">Memuat contoh pertanyaan...</div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bottom Typing & Input Bar -->
    <div class="mt-3">
        <!-- Error Alert -->
        <div id="chatErrorAlert" class="hidden mb-2 px-4 py-2.5 rounded-2xl bg-red-50 border border-red-200 text-red-700 text-xs font-medium flex items-center gap-2">
            <i class="bi bi-exclamation-triangle-fill text-red-500"></i>
            <span id="chatErrorText"></span>
        </div>

        <form id="chatForm" class="flex items-center gap-2 bg-white/90 backdrop-blur-md border border-slate-200/80 p-2 md:p-2.5 rounded-full shadow-lg shadow-slate-200/40">
            <input
                type="text"
                id="messageInput"
                placeholder="Tanyakan soal atau topik pelajaran di sini..."
                autocomplete="off"
                required
                class="flex-1 px-5 py-2.5 bg-transparent border-0 text-slate-900 text-sm font-medium placeholder:text-slate-400 focus:outline-none focus:ring-0"
            >

            <button
                type="submit"
                id="sendBtn"
                class="w-11 h-11 rounded-full bg-gradient-to-r from-terracotta to-orange-600 hover:from-terracotta-hover hover:to-orange-700 text-white flex items-center justify-center shadow-md shadow-terracotta/20 hover:shadow-lg hover:scale-105 active:scale-95 transition-all duration-200 shrink-0 disabled:opacity-50 disabled:hover:scale-100 disabled:cursor-not-allowed"
            >
                <i class="bi bi-send-fill text-base ml-0.5" id="sendBtnIcon"></i>
                <svg id="sendBtnSpinner" class="hidden animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </button>
        </form>
    </div>

</div>

<!-- JavaScript Chat Controller -->
<script>
    let allTopicsData = [];
    let activeTopicId = null;
    let activeSessionId = null;

    document.addEventListener('DOMContentLoaded', () => {
        const token = localStorage.getItem('access_token');
        if (!token) {
            window.location.href = '/login';
            return;
        }

        const urlParams = new URLSearchParams(window.location.search);
        activeSessionId = urlParams.get('session_id') ? parseInt(urlParams.get('session_id')) : null;
        activeTopicId = urlParams.get('topic_id') ? parseInt(urlParams.get('topic_id')) : null;
        const initialPrompt = urlParams.get('prompt');

        const chatFeed = document.getElementById('chatFeed');
        const welcomeBanner = document.getElementById('welcomeBanner');
        const chatForm = document.getElementById('chatForm');
        const messageInput = document.getElementById('messageInput');
        const sendBtn = document.getElementById('sendBtn');
        const sendBtnIcon = document.getElementById('sendBtnIcon');
        const sendBtnSpinner = document.getElementById('sendBtnSpinner');
        const chatErrorAlert = document.getElementById('chatErrorAlert');
        const chatErrorText = document.getElementById('chatErrorText');

        // Load all topics via Eloquent ORM API first
        loadTopicsFromDatabase();

        // Load session history if session_id is present
        if (activeSessionId) {
            loadSessionHistory(activeSessionId);
        }

        // Auto-send prompt if passed in URL query
        if (initialPrompt && !activeSessionId) {
            messageInput.value = initialPrompt;
            setTimeout(() => {
                chatForm.dispatchEvent(new Event('submit'));
            }, 500);
        }

        // Handle Form Submit
        chatForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const message = messageInput.value.trim();
            if (!message) return;

            // Clear input & disable button
            messageInput.value = '';
            setLoading(true);
            hideError();

            // Hide welcome banner if visible
            if (welcomeBanner) {
                welcomeBanner.classList.add('hidden');
            }

            // Append User Message Bubble
            appendMessageBubble('user', message);
            scrollToBottom();

            // Append Typing Indicator Bubble
            const typingBubbleId = appendTypingIndicator();
            scrollToBottom();

            try {
                const payload = { message };
                if (activeSessionId) {
                    payload.session_id = activeSessionId;
                } else if (activeTopicId) {
                    payload.topic_id = activeTopicId;
                }

                const response = await fetch('/api/chat', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${token}`
                    },
                    body: JSON.stringify(payload)
                });

                const data = await response.json();
                removeTypingIndicator(typingBubbleId);

                if (response.ok && data.status === 'success') {
                    // Update activeSessionId
                    activeSessionId = data.data.session_id;

                    // Update URL state without page reload
                    const newUrl = new URL(window.location.href);
                    newUrl.searchParams.set('session_id', activeSessionId);
                    if (initialPrompt) newUrl.searchParams.delete('prompt');
                    window.history.pushState({}, '', newUrl);

                    // Refresh Sidebar History
                    window.dispatchEvent(new Event('refreshSidebarHistory'));

                    // Append Bot Message Bubble
                    const botMsg = data.data.bot_message;
                    appendMessageBubble('bot', botMsg.message, botMsg.id, data.data.model_used);
                    scrollToBottom();
                } else {
                    showError(data.message || 'Gagal mengirim pesan. Silakan coba lagi.');
                }
            } catch (err) {
                removeTypingIndicator(typingBubbleId);
                showError('Terjadi masalah koneksi jaringan.');
            } finally {
                setLoading(false);
            }
        });

        // Function: Load Topics & Example Prompts from Database via Eloquent API
        async function loadTopicsFromDatabase() {
            try {
                const res = await fetch('/api/topics', {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${token}`
                    }
                });

                const data = await res.json();
                if (res.ok && data.status === 'success') {
                    allTopicsData = data.data;
                    renderTopicPills(allTopicsData);
                    renderExamplePrompts(activeTopicId);
                }
            } catch (e) {
                console.error('Failed to load topics', e);
            }
        }

        // Render Topic Pills in Top Bar
        function renderTopicPills(topics) {
            const container = document.getElementById('topicSelectorPills');
            const topicEmojis = {
                'Matematika Dasar': '🍕',
                'Sains': '🚀',
                'Bahasa': '📚',
                'Pengetahuan Umum': '🌐'
            };

            let html = `
                <button onclick="selectTopic(null)" class="topic-pill px-3.5 py-1.5 rounded-full text-xs font-bold transition-all border shrink-0 ${!activeTopicId ? 'bg-terracotta text-white border-terracotta shadow-sm' : 'bg-slate-100 text-slate-700 border-slate-200 hover:bg-amber-50'}" data-topic-id="all">
                    💬 Umum
                </button>
            `;

            topics.forEach(t => {
                const emoji = topicEmojis[t.name] || '📖';
                const isSelected = activeTopicId === t.id;
                html += `
                    <button onclick="selectTopic(${t.id})" class="topic-pill px-3.5 py-1.5 rounded-full text-xs font-bold transition-all border shrink-0 ${isSelected ? 'bg-terracotta text-white border-terracotta shadow-sm' : 'bg-slate-100 text-slate-700 border-slate-200 hover:bg-amber-50'}" data-topic-id="${t.id}">
                        ${emoji} ${t.name}
                    </button>
                `;
            });

            container.innerHTML = html;
        }

        // Render Example Prompts Chips in Banner based on Selected Topic
        function renderExamplePrompts(topicId) {
            const container = document.getElementById('samplePromptChips');
            const welcomeTitle = document.getElementById('welcomeTitle');
            const welcomeEmoji = document.getElementById('welcomeEmoji');
            const badge = document.getElementById('topicBadge');

            let promptsToDisplay = [];
            let currentTopic = null;

            if (topicId) {
                currentTopic = allTopicsData.find(t => t.id === topicId);
            }

            if (currentTopic) {
                promptsToDisplay = currentTopic.example_prompts ? currentTopic.example_prompts.map(ep => ep.question_text) : [];
                welcomeTitle.textContent = `Belajar ${currentTopic.name}`;
                badge.textContent = currentTopic.name;
                badge.classList.remove('hidden');

                const topicEmojis = { 'Matematika Dasar': '🍕', 'Sains': '🚀', 'Bahasa': '📚', 'Pengetahuan Umum': '🌐' };
                welcomeEmoji.textContent = topicEmojis[currentTopic.name] || '📖';
            } else {
                // Collect default prompts across all topics
                allTopicsData.forEach(t => {
                    if (t.example_prompts && t.example_prompts.length > 0) {
                        promptsToDisplay.push(t.example_prompts[0].question_text);
                    }
                });
                welcomeTitle.textContent = 'Halo, Adik Pintar!';
                welcomeEmoji.textContent = '👋';
                badge.classList.add('hidden');
            }

            if (promptsToDisplay.length === 0) {
                container.innerHTML = `<div class="text-slate-400 text-xs font-medium">Belum ada saran pertanyaan.</div>`;
                return;
            }

            let html = '';
            promptsToDisplay.forEach(qText => {
                html += `
                    <button onclick="sendPromptDirectly('${escapeHtml(qText)}')" class="px-3 py-2 rounded-full bg-white border border-slate-200/90 text-slate-800 text-xs font-bold shadow-sm hover:bg-amber-50 hover:border-amber-300 hover:text-terracotta transition-all text-left flex items-center gap-1.5">
                        <span>💬 "${escapeHtml(qText)}"</span>
                    </button>
                `;
            });

            container.innerHTML = html;
        }

        // Global Topic Selection Handler
        window.selectTopic = function(topicId) {
            activeTopicId = topicId;
            renderTopicPills(allTopicsData);
            renderExamplePrompts(activeTopicId);

            // Update URL query
            const newUrl = new URL(window.location.href);
            if (topicId) {
                newUrl.searchParams.set('topic_id', topicId);
            } else {
                newUrl.searchParams.delete('topic_id');
            }
            window.history.pushState({}, '', newUrl);
        };

        // Function: Load Existing Session History
        async function loadSessionHistory(sessionId) {
            try {
                const res = await fetch(`/api/chat/history/${sessionId}`, {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${token}`
                    }
                });

                const data = await res.json();
                if (res.ok && data.status === 'success') {
                    const session = data.data.session;
                    const messages = data.data.messages;

                    document.getElementById('chatSessionTitle').textContent = session.title || 'Percakapan Tutor';
                    if (session.topic) {
                        const badge = document.getElementById('topicBadge');
                        badge.textContent = session.topic.name;
                        badge.classList.remove('hidden');
                        activeTopicId = session.topic.id;
                    }

                    if (welcomeBanner) welcomeBanner.classList.add('hidden');

                    messages.forEach(msg => {
                        appendMessageBubble(msg.sender_type, msg.message, msg.id, null, msg.is_favorite);
                    });

                    // Logika Auto-Scroll & Highlight pesan tertentu jika diminta di URL
                    const urlParams = new URLSearchParams(window.location.search);
                    const highlightId = urlParams.get('highlight_message_id');
                    if (highlightId) {
                        setTimeout(() => {
                            const targetEl = document.getElementById(`msg-${highlightId}`);
                            if (targetEl) {
                                targetEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                // Tambahkan efek denyut warna Mustard / Amber untuk highlight premium
                                targetEl.classList.add('ring-4', 'ring-amber-400', 'bg-amber-50/50', 'rounded-2xl', 'p-2', 'transition-all', 'duration-500');
                                setTimeout(() => {
                                    targetEl.classList.remove('ring-4', 'ring-amber-400', 'bg-amber-50/50', 'p-2');
                                }, 3000);
                            } else {
                                scrollToBottom();
                            }
                        }, 600);
                    } else {
                        scrollToBottom();
                    }
                }
            } catch (e) {
                console.error('Failed to load session history', e);
            }
        }

        // Function: Append Message Bubble
        function appendMessageBubble(sender, text, msgId = null, modelUsed = null, isFavorite = false) {
            const wrapper = document.createElement('div');
            wrapper.className = `flex ${sender === 'user' ? 'justify-end' : 'justify-start'} animate-fade-in my-2`;
            if (msgId) {
                wrapper.id = `msg-${msgId}`;
            }

            if (sender === 'user') {
                wrapper.innerHTML = `
                    <div class="max-w-[85%] sm:max-w-[75%] px-4 py-3 rounded-2xl rounded-tr-sm bg-gradient-to-r from-terracotta to-orange-600 text-white font-medium text-sm shadow-md shadow-terracotta/15 leading-relaxed">
                        ${escapeHtml(text)}
                    </div>
                `;
            } else {
                const formattedText = formatMarkdown(text);
                wrapper.innerHTML = `
                    <div class="flex items-start gap-3 max-w-[90%] sm:max-w-[80%]">
                        <div class="w-9 h-9 bg-gradient-to-br from-terracotta to-amber-500 rounded-2xl flex items-center justify-center text-white text-base shrink-0 shadow-md shadow-terracotta/20 mt-1">
                            🤖
                        </div>
                        <div class="bg-white border border-slate-200/80 rounded-2xl rounded-tl-sm p-4 text-slate-800 shadow-sm leading-relaxed space-y-2">
                            <div class="text-sm font-medium font-sans prose prose-slate">
                                ${formattedText}
                            </div>
                            <div class="flex items-center justify-between pt-2 border-t border-slate-100 text-[11px] text-slate-400 font-semibold gap-4">
                                <div class="flex items-center gap-2">
                                    <span><i class="bi bi-robot text-terracotta mr-1"></i> Kakak AI Tutor</span>
                                    <span class="bg-slate-100 px-2 py-0.5 rounded-full">${modelUsed || 'AI Buddy'}</span>
                                </div>
                                ${msgId ? `
                                <button onclick="toggleFavoriteMessage(${msgId}, this)" class="flex items-center gap-1 px-2 py-1 rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-600 border border-amber-200/50 hover:border-amber-300 transition-all font-outfit" title="${isFavorite ? 'Hapus dari Favorit' : 'Simpan Jawaban Favorit'}">
                                    <i class="bi ${isFavorite ? 'bi-star-fill text-amber-500' : 'bi-star'}"></i>
                                    <span>Favorit</span>
                                </button>
                                ` : ''}
                            </div>
                        </div>
                    </div>
                `;
            }

            chatFeed.appendChild(wrapper);
        }

        // Action: Toggle Favorite API
        window.toggleFavoriteMessage = async function(messageId, btnElement) {
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

                const result = await res.json();
                if (res.ok && result.status === 'success') {
                    const icon = btnElement.querySelector('i');
                    if (result.is_favorite) {
                        icon.className = 'bi bi-star-fill text-amber-500';
                        btnElement.title = 'Hapus dari Favorit';
                    } else {
                        icon.className = 'bi bi-star';
                        btnElement.title = 'Simpan Jawaban Favorit';
                    }
                } else {
                    alert(result.message || 'Gagal mengubah favorit.');
                }
            } catch (e) {
                alert('Gagal mengubah favorit karena masalah koneksi.');
            }
        };

        // Function: Append Typing Indicator
        function appendTypingIndicator() {
            const id = 'typing_' + Date.now();
            const wrapper = document.createElement('div');
            wrapper.id = id;
            wrapper.className = 'flex justify-start my-2 animate-fade-in';
            wrapper.innerHTML = `
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-amber-100 rounded-2xl flex items-center justify-center text-base shrink-0 shadow-inner">
                        🤖
                    </div>
                    <div class="bg-white border border-slate-200/80 rounded-2xl rounded-tl-sm px-4 py-3 text-slate-500 shadow-sm flex items-center gap-1.5 text-xs font-semibold">
                        <span>Kakak AI sedang mengetik</span>
                        <span class="flex items-center gap-1 ml-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-terracotta animate-bounce" style="animation-delay: 0ms"></span>
                            <span class="w-1.5 h-1.5 rounded-full bg-terracotta animate-bounce" style="animation-delay: 150ms"></span>
                            <span class="w-1.5 h-1.5 rounded-full bg-terracotta animate-bounce" style="animation-delay: 300ms"></span>
                        </span>
                    </div>
                </div>
            `;
            chatFeed.appendChild(wrapper);
            return id;
        }

        function removeTypingIndicator(id) {
            const el = document.getElementById(id);
            if (el) el.remove();
        }

        function scrollToBottom() {
            chatFeed.scrollTop = chatFeed.scrollHeight;
        }

        function setLoading(isLoading) {
            messageInput.disabled = isLoading;
            sendBtn.disabled = isLoading;
            if (isLoading) {
                sendBtnIcon.classList.add('hidden');
                sendBtnSpinner.classList.remove('hidden');
            } else {
                sendBtnIcon.classList.remove('hidden');
                sendBtnSpinner.classList.add('hidden');
                messageInput.focus();
            }
        }

        function showError(msg) {
            chatErrorText.textContent = msg;
            chatErrorAlert.classList.remove('hidden');
        }

        function hideError() {
            chatErrorAlert.classList.add('hidden');
        }

        function escapeHtml(str) {
            return str.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
        }

        function formatMarkdown(text) {
            let formatted = escapeHtml(text);
            formatted = formatted.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
            formatted = formatted.replace(/\n/g, '<br>');
            return formatted;
        }

        // Global helper for prompt chips
        window.sendPromptDirectly = function(promptText) {
            messageInput.value = promptText;
            chatForm.dispatchEvent(new Event('submit'));
        };
    });
</script>
@endsection
