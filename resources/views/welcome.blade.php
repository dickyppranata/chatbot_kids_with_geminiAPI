<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AI Buddy - Sahabat Belajar Interaktif Anak</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Laravel Vite Asset Compiler -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-15px) rotate(2deg); }
        }
        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-float-delay { animation: float 6s ease-in-out 2s infinite; }
    </style>
</head>
<body class="bg-cream-bg text-slate-900 min-h-screen font-sans antialiased">

    <!-- Background Ambient Glowing Orbs -->
    <div class="fixed top-0 left-0 w-96 h-96 bg-terracotta/10 rounded-full filter blur-[100px] -z-10 animate-float pointer-events-none"></div>
    <div class="fixed bottom-0 right-0 w-[450px] h-[450px] bg-amber-500/10 rounded-full filter blur-[120px] -z-10 animate-float-delay pointer-events-none"></div>

    <!-- Navigation Header -->
    <header class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-slate-200/60">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="/" class="flex items-center gap-3 no-underline group">
                <div class="w-10 h-10 bg-gradient-to-br from-terracotta to-amber-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-terracotta/20 transition-transform group-hover:scale-105">
                    <i class="bi bi-robot text-xl"></i>
                </div>
                <div>
                    <span class="font-outfit font-extrabold text-xl tracking-tight text-slate-900 block leading-none">AI Buddy</span>
                    <span class="text-[10px] font-semibold text-terracotta">Sahabat Belajar Pintar</span>
                </div>
            </a>

            <div class="flex items-center gap-3">
                <a href="/login" class="px-5 py-2.5 rounded-full bg-white border border-slate-200 text-slate-700 font-outfit font-bold text-sm hover:bg-slate-50 transition-all no-underline shadow-sm">Masuk</a>
                <a href="/register" class="px-5 py-2.5 rounded-full bg-gradient-to-r from-terracotta to-orange-600 text-white font-outfit font-bold text-sm shadow-md shadow-terracotta/20 hover:shadow-lg hover:shadow-terracotta/30 hover:-translate-y-0.5 transition-all no-underline">Daftar Akun</a>
            </div>
        </div>
    </header>

    <div class="max-w-6xl mx-auto px-6">

        <!-- Hero Section -->
        <section class="py-16 md:py-24 grid md:grid-cols-2 gap-12 items-center">
            <div class="space-y-6 text-center md:text-left">
                <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-100 border border-amber-200 text-terracotta text-xs font-bold uppercase tracking-wider">
                    🌟 Tutor AI Khusus Anak SD / SMP (10-14 Tahun)
                </span>
                <h1 class="font-outfit font-extrabold text-4xl md:text-5xl leading-tight tracking-tight text-slate-900">
                    Belajar Lebih Seru Bersama <span class="bg-gradient-to-r from-terracotta to-amber-500 bg-clip-text text-transparent">Teman AI Pintarmu!</span>
                </h1>
                <p class="text-base md:text-lg text-slate-600 leading-relaxed font-medium">
                    Belajar matematika, sains, bahasa, dan pengetahuan umum menjadi lebih interaktif. AI Buddy membimbingmu lewat percakapan yang ramah, analogi seru, dan latihan soal yang mudah dipahami.
                </p>
                <div class="flex flex-wrap gap-4 justify-center md:justify-start pt-2">
                    <a href="/register" class="px-7 py-3.5 rounded-full bg-gradient-to-r from-terracotta to-orange-600 text-white font-outfit font-extrabold text-base shadow-lg shadow-terracotta/25 hover:shadow-xl hover:shadow-terracotta/35 hover:-translate-y-0.5 transition-all no-underline inline-flex items-center gap-2">
                        <span>Mulai Belajar Sekarang</span>
                        <i class="bi bi-arrow-right-short text-2xl"></i>
                    </a>
                    <a href="#topics" class="px-6 py-3.5 rounded-full bg-white border border-slate-200/80 text-slate-700 font-outfit font-bold text-base hover:bg-slate-50 transition-all no-underline shadow-sm">
                        Lihat Topik Belajar
                    </a>
                </div>
            </div>

            <!-- Chat Simulator Widget -->
            <div class="w-full bg-white/80 backdrop-blur-md border border-slate-200/80 rounded-3xl shadow-xl shadow-slate-200/50 overflow-hidden flex flex-col h-[400px] relative transition-transform hover:scale-[1.01]">
                <div class="px-6 py-4 bg-slate-100/60 border-b border-slate-200/60 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-terracotta to-amber-500 rounded-2xl flex items-center justify-center text-white font-bold text-lg shadow-md shadow-terracotta/20">
                            🤖
                        </div>
                        <div>
                            <h3 class="font-outfit font-extrabold text-sm text-slate-900 leading-none">Kakak AI Tutor</h3>
                            <span class="text-xs text-emerald-600 font-bold flex items-center gap-1.5 mt-0.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span> Siap Membimbing Belajar
                            </span>
                        </div>
                    </div>
                </div>

                <div class="flex-1 p-5 overflow-y-auto flex flex-col gap-3 font-medium text-sm" id="chatMockBody">
                    <!-- Chat bubbles loaded dynamically -->
                </div>

                <!-- Simulation Chips -->
                <div class="absolute bottom-16 left-0 right-0 flex gap-2.5 justify-center px-4" id="mockChipsContainer">
                    <button onclick="simulateChat('math')" class="px-4 py-2 rounded-full bg-white border border-slate-200 shadow-md text-xs font-bold text-slate-700 hover:bg-amber-50 hover:border-amber-300 hover:text-terracotta transition-all flex items-center gap-1.5">
                        <span>🍕 Matematika Dasar</span>
                    </button>
                    <button onclick="simulateChat('science')" class="px-4 py-2 rounded-full bg-white border border-slate-200 shadow-md text-xs font-bold text-slate-700 hover:bg-amber-50 hover:border-amber-300 hover:text-terracotta transition-all flex items-center gap-1.5">
                        <span>🚀 Sains & Alam</span>
                    </button>
                </div>

                <div class="p-3 bg-slate-50/70 border-t border-slate-200/60 flex items-center justify-between gap-3">
                    <div class="flex-1 py-2 px-4 bg-white border border-slate-200 rounded-full text-xs text-slate-500 flex items-center gap-2" id="mockInputBar">
                        <i class="bi bi-keyboard"></i> Klik salah satu topik di atas untuk coba simulasi...
                    </div>
                    <button class="w-9 h-9 rounded-full bg-terracotta flex items-center justify-center text-white shadow-md">
                        <i class="bi bi-send-fill text-xs"></i>
                    </button>
                </div>
            </div>
        </section>

        <!-- Topics Showcase -->
        <section id="topics" class="py-16 border-t border-slate-200/60">
            <div class="text-center max-w-2xl mx-auto mb-12 space-y-3">
                <h2 class="font-outfit font-extrabold text-3xl text-slate-900">
                    Pilih Topik Belajar Favoritmu
                </h2>
                <p class="text-sm md:text-base text-slate-500 font-medium">
                    AI Tutor dirancang khusus untuk memandu materi pelajaran SD & SMP dengan penjelasan sederhana dan contoh menarik.
                </p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Matematika Dasar -->
                <div class="group relative bg-white/80 backdrop-blur-md border border-slate-200/60 rounded-3xl p-6 shadow-sm hover:shadow-xl hover:shadow-terracotta/5 hover:-translate-y-1 transition-all duration-300">
                    <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-orange-500 to-amber-500 rounded-t-3xl"></div>
                    <div class="w-14 h-14 bg-amber-100 rounded-2xl flex items-center justify-center text-3xl mb-4 shadow-inner">
                        🍕
                    </div>
                    <h3 class="font-outfit font-extrabold text-xl text-slate-900 mb-2 group-hover:text-terracotta transition-colors">Matematika Dasar</h3>
                    <p class="text-xs md:text-sm text-slate-500 leading-relaxed font-medium">
                        Pecahan, bangun ruang, perkalian, dan logika angka dengan contoh analogi seru seperti potongan kue.
                    </p>
                </div>

                <!-- Sains -->
                <div class="group relative bg-white/80 backdrop-blur-md border border-slate-200/60 rounded-3xl p-6 shadow-sm hover:shadow-xl hover:shadow-terracotta/5 hover:-translate-y-1 transition-all duration-300">
                    <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-t-3xl"></div>
                    <div class="w-14 h-14 bg-cyan-100 rounded-2xl flex items-center justify-center text-3xl mb-4 shadow-inner">
                        🚀
                    </div>
                    <h3 class="font-outfit font-extrabold text-xl text-slate-900 mb-2 group-hover:text-terracotta transition-colors">Sains & Alam</h3>
                    <p class="text-xs md:text-sm text-slate-500 leading-relaxed font-medium">
                        Menjelaskan fenomena alam seperti hujan, bintang, fotosintesis, dan rahasia semesta.
                    </p>
                </div>

                <!-- Bahasa -->
                <div class="group relative bg-white/80 backdrop-blur-md border border-slate-200/60 rounded-3xl p-6 shadow-sm hover:shadow-xl hover:shadow-terracotta/5 hover:-translate-y-1 transition-all duration-300">
                    <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-emerald-500 to-teal-400 rounded-t-3xl"></div>
                    <div class="w-14 h-14 bg-emerald-100 rounded-2xl flex items-center justify-center text-3xl mb-4 shadow-inner">
                        📚
                    </div>
                    <h3 class="font-outfit font-extrabold text-xl text-slate-900 mb-2 group-hover:text-terracotta transition-colors">Bahasa Indonesia</h3>
                    <p class="text-xs md:text-sm text-slate-500 leading-relaxed font-medium">
                        Menguasai kosakata baru, sinonim & antonim, tata bahasa, dan cara membuat cerita seru.
                    </p>
                </div>

                <!-- Pengetahuan Umum -->
                <div class="group relative bg-white/80 backdrop-blur-md border border-slate-200/60 rounded-3xl p-6 shadow-sm hover:shadow-xl hover:shadow-terracotta/5 hover:-translate-y-1 transition-all duration-300">
                    <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-violet-500 to-purple-500 rounded-t-3xl"></div>
                    <div class="w-14 h-14 bg-violet-100 rounded-2xl flex items-center justify-center text-3xl mb-4 shadow-inner">
                        🌐
                    </div>
                    <h3 class="font-outfit font-extrabold text-xl text-slate-900 mb-2 group-hover:text-terracotta transition-colors">Pengetahuan Umum</h3>
                    <p class="text-xs md:text-sm text-slate-500 leading-relaxed font-medium">
                        Mempelajari fakta-fakta dunia, geografi menarik, sejarah tokoh penting, dan budaya.
                    </p>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-16 px-8 md:px-12 bg-white/80 border border-slate-200/60 rounded-[32px] my-12 shadow-sm">
            <div class="text-center max-w-xl mx-auto mb-12">
                <h2 class="font-outfit font-extrabold text-3xl text-slate-900">
                    Konsep Belajar yang Berbeda
                </h2>
                <p class="text-sm text-slate-500 font-semibold mt-2">
                    Dirancang khusus untuk mendukung kenyamanan dan keaktifan anak-anak saat belajar mandiri.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="space-y-3 flex flex-col items-center md:items-start text-center md:text-left">
                    <div class="w-13 h-13 rounded-2xl bg-amber-100 flex items-center justify-center text-terracotta text-2xl font-bold">
                        <i class="bi bi-chat-text-fill"></i>
                    </div>
                    <h3 class="font-outfit font-bold text-lg text-slate-900">Tutor AI yang Membimbing</h3>
                    <p class="text-xs md:text-sm text-slate-500 leading-relaxed font-medium">
                        AI tidak hanya menjawab instan, tetapi juga menjelaskan secara runtut dan memastikan anak-anak benar-benar paham.
                    </p>
                </div>

                <div class="space-y-3 flex flex-col items-center md:items-start text-center md:text-left">
                    <div class="w-13 h-13 rounded-2xl bg-amber-100 flex items-center justify-center text-terracotta text-2xl font-bold">
                        <i class="bi bi-pencil-square"></i>
                    </div>
                    <h3 class="font-outfit font-bold text-lg text-slate-900">Latihan Soal dalam Chat</h3>
                    <p class="text-xs md:text-sm text-slate-500 leading-relaxed font-medium">
                        Setelah anak paham materi, AI langsung memberikan latihan interaktif di dalam thread percakapan alami.
                    </p>
                </div>

                <div class="space-y-3 flex flex-col items-center md:items-start text-center md:text-left">
                    <div class="w-13 h-13 rounded-2xl bg-amber-100 flex items-center justify-center text-terracotta text-2xl font-bold">
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <h3 class="font-outfit font-bold text-lg text-slate-900">Simpan Jawaban Favorit</h3>
                    <p class="text-xs md:text-sm text-slate-500 leading-relaxed font-medium">
                        Anak-anak dapat menyimpan penjelasan penting agar mudah dibaca kembali kapan saja tanpa repot mencari riwayat.
                    </p>
                </div>
            </div>
        </section>

    </div>

    <!-- Footer -->
    <footer class="py-12 border-t border-slate-200/60 text-center text-xs text-slate-500 font-semibold">
        <div class="max-w-6xl mx-auto px-6">
            <p>&copy; 2026 AI Buddy. Didesain dengan penuh kepedulian untuk pendidikan anak Indonesia.</p>
        </div>
    </footer>

    <!-- Script: Simulation -->
    <script>
        // Force Light Mode
        document.documentElement.classList.remove('dark');
        localStorage.removeItem('theme');

        // Chat Simulator Data
        const simulationData = {
            math: [
                { sender: 'user', text: 'Apa itu pecahan?' },
                { sender: 'bot', text: 'Halo Dek! 🍕 Bayangkan kamu punya 1 pizza utuh, lalu dipotong menjadi 4 bagian yang sama besar. Jika kamu makan 1 bagian, artinya kamu memakan 1 dari 4 potongan itu, ditulis <b>1/4</b> (satu per empat). Angka 1 di atas disebut pembilang, dan 4 di bawah disebut penyebut. Apakah penjelasan Kakak sudah jelas, Dek?' },
                { sender: 'user', text: 'Sudah paham, Kak!' },
                { sender: 'bot', text: 'Hebat sekali! 🎉 Nah, sekarang coba tebak kuis kecil ini: Jika sebatang cokelat dibagi menjadi 8 bagian dan kamu makan 3 bagian, maka bentuk pecahannya adalah berapa? Coba jawab ya!' }
            ],
            science: [
                { sender: 'user', text: 'Mengapa hujan turun?' },
                { sender: 'bot', text: 'Halo Dek! 🌧️ Hujan terjadi karena air di laut dan sungai menguap ke langit akibat panas matahari. Uap air berkumpul menjadi awan. Ketika awan mendingin dan sudah terlalu berat memuat uap air, titik-titik air itu akan jatuh ke bumi sebagai air hujan. Apakah kamu sudah mengerti penjelasan Kakak, Dek?' },
                { sender: 'user', text: 'Belum begitu paham bagian menguap.' },
                { sender: 'bot', text: 'Oke Dek! 💧 Bayangkan ketika ibumu memasak air panas di panci, lalu ada asap putih mengepul ke atas. Nah, uap air yang naik ke langit itu seperti asap panci tersebut, menguap dari air hangat laut akibat matahari. Bagaimana Dek, sekarang sudah lebih paham?' }
            ]
        };

        const chatMockBody = document.getElementById('chatMockBody');
        const mockInputBar = document.getElementById('mockInputBar');
        const mockChipsContainer = document.getElementById('mockChipsContainer');

        let isSimulating = false;

        function addMessage(sender, text, delay) {
            return new Promise((resolve) => {
                setTimeout(() => {
                    const outerDiv = document.createElement('div');
                    outerDiv.className = `flex ${sender === 'user' ? 'justify-end' : 'justify-start'} animate-fade-in`;

                    const bubble = document.createElement('div');
                    bubble.className = `max-w-[85%] px-4 py-3 rounded-2xl text-sm leading-relaxed ${
                        sender === 'user'
                        ? 'bg-amber-100 text-slate-800 font-medium rounded-tr-sm'
                        : 'bg-white border border-slate-200 text-slate-800 rounded-tl-sm shadow-sm'
                    }`;
                    bubble.innerHTML = text;

                    outerDiv.appendChild(bubble);
                    chatMockBody.appendChild(outerDiv);
                    chatMockBody.scrollTop = chatMockBody.scrollHeight;
                    resolve();
                }, delay);
            });
        }

        async function simulateChat(topic) {
            if (isSimulating) return;
            isSimulating = true;

            chatMockBody.innerHTML = '';
            mockChipsContainer.classList.add('hidden');
            mockInputBar.innerHTML = '<i class="bi bi-clock"></i> Sedang mengetik...';

            const conversation = simulationData[topic];

            for (let i = 0; i < conversation.length; i++) {
                const message = conversation[i];
                if (message.sender === 'user') {
                    mockInputBar.innerHTML = `<i class="bi bi-keyboard"></i> Mengetik: "${message.text}"`;
                    await addMessage('user', message.text, 1000);
                    mockInputBar.innerHTML = '<i class="bi bi-cpu text-terracotta"></i> Kakak AI sedang merespons...';
                } else {
                    await addMessage('bot', message.text, 2200);
                }
            }

            mockInputBar.innerHTML = '<i class="bi bi-check-circle-fill text-emerald-500"></i> Simulasi selesai! Coba topik lain.';
            mockChipsContainer.classList.remove('hidden');
            isSimulating = false;
        }

        // Start welcoming message
        addMessage('bot', 'Halo adik pintar! 👋 Aku adalah Kakak AI Tutor-mu. Mau belajar apa hari ini? Klik salah satu topik di bawah untuk mencoba simulasi belajarnya, ya!', 500);
    </script>
</body>
</html>
