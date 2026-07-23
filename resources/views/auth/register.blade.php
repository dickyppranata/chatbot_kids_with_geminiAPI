<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Buat akun AI Buddy - Sahabat Belajar Interaktif untuk Anak Indonesia">
    <title>Daftar Akun - AI Buddy</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-15px) rotate(2deg); }
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-float-delay { animation: float 6s ease-in-out 2s infinite; }
        .animate-fade-in-up { animation: fadeInUp 0.6s ease-out both; }
        .input-focus-glow:focus-within {
            box-shadow: 0 0 0 3px rgba(194, 65, 12, 0.15), 0 0 20px rgba(194, 65, 12, 0.08);
        }
        .strength-bar { transition: width 0.3s ease, background-color 0.3s ease; }
    </style>
</head>
<body class="bg-cream-bg text-slate-900 min-h-screen font-sans antialiased">

    <!-- Background Ambient Glowing Orbs -->
    <div class="fixed top-0 left-0 w-[500px] h-[500px] bg-terracotta/10 rounded-full filter blur-[120px] -z-10 animate-float pointer-events-none"></div>
    <div class="fixed bottom-0 right-0 w-[450px] h-[450px] bg-amber-500/10 rounded-full filter blur-[100px] -z-10 animate-float-delay pointer-events-none"></div>

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

            <div class="flex items-center gap-4">
                <a href="/login" class="px-5 py-2.5 rounded-full bg-white border border-slate-200 text-slate-700 font-outfit font-bold text-sm hover:bg-slate-50 transition-all no-underline shadow-sm">Masuk</a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="min-h-[calc(100vh-80px)] flex items-center justify-center px-6 py-12">
        <div class="w-full max-w-md animate-fade-in-up">

            <!-- Card -->
            <div class="bg-white/80 backdrop-blur-md border border-slate-200/60 rounded-3xl shadow-xl shadow-slate-200/50 overflow-hidden">

                <!-- Card Header -->
                <div class="px-8 pt-10 pb-2 text-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-terracotta to-amber-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-terracotta/20 mx-auto mb-5 animate-float">
                        <i class="bi bi-person-plus-fill text-3xl"></i>
                    </div>
                    <h1 class="font-outfit font-extrabold text-2xl md:text-3xl text-slate-900">
                        Buat Akun Baru
                    </h1>
                    <p class="text-sm text-slate-500 font-medium mt-2">
                        Bergabung bersama AI Buddy dan mulai petualangan belajarmu!
                    </p>
                </div>

                <!-- Form (Standard Laravel POST) -->
                <form action="/register" method="POST" class="px-8 pb-8 pt-6 space-y-5">
                    @csrf

                    <!-- Global Error Alert -->
                    @if($errors->any())
                        <div class="px-4 py-3 rounded-2xl bg-red-50 border border-red-200 text-red-700 text-sm font-medium flex items-center gap-2">
                            <i class="bi bi-exclamation-triangle-fill text-red-500"></i>
                            <span>{{ $errors->first() }}</span>
                        </div>
                    @endif

                    <!-- Name Input -->
                    <div class="space-y-2">
                        <label for="name" class="block text-sm font-outfit font-bold text-slate-700">
                            <i class="bi bi-person-fill text-terracotta mr-1"></i> Nama Lengkap
                        </label>
                        <div class="relative input-focus-glow rounded-2xl transition-all duration-200">
                            <input
                                type="text"
                                id="name"
                                name="name"
                                required
                                autocomplete="name"
                                placeholder="Masukkan nama lengkap"
                                value="{{ old('name') }}"
                                class="w-full px-4 py-3.5 bg-slate-50 border {{ $errors->has('name') ? 'border-red-400' : 'border-slate-200' }} rounded-2xl text-sm font-medium text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-terracotta transition-colors"
                            >
                        </div>
                        @error('name')
                            <p class="text-xs text-red-500 font-medium mt-1 pl-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Input -->
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-outfit font-bold text-slate-700">
                            <i class="bi bi-envelope-fill text-terracotta mr-1"></i> Email
                        </label>
                        <div class="relative input-focus-glow rounded-2xl transition-all duration-200">
                            <input
                                type="email"
                                id="email"
                                name="email"
                                required
                                autocomplete="email"
                                placeholder="contoh@email.com"
                                value="{{ old('email') }}"
                                class="w-full px-4 py-3.5 bg-slate-50 border {{ $errors->has('email') ? 'border-red-400' : 'border-slate-200' }} rounded-2xl text-sm font-medium text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-terracotta transition-colors"
                            >
                        </div>
                        @error('email')
                            <p class="text-xs text-red-500 font-medium mt-1 pl-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Input -->
                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-outfit font-bold text-slate-700">
                            <i class="bi bi-lock-fill text-terracotta mr-1"></i> Password
                        </label>
                        <div class="relative input-focus-glow rounded-2xl transition-all duration-200">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                required
                                autocomplete="new-password"
                                placeholder="Minimal 6 karakter"
                                class="w-full px-4 py-3.5 pr-12 bg-slate-50 border {{ $errors->has('password') ? 'border-red-400' : 'border-slate-200' }} rounded-2xl text-sm font-medium text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-terracotta transition-colors"
                            >
                            <button
                                type="button"
                                id="togglePassword"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-terracotta transition-colors p-1"
                                aria-label="Toggle password visibility"
                            >
                                <i class="bi bi-eye-fill" id="eyeIcon"></i>
                            </button>
                        </div>
                        <!-- Password Strength Bar -->
                        <div class="flex items-center gap-2 px-1">
                            <div class="flex-1 h-1.5 bg-slate-200 rounded-full overflow-hidden">
                                <div id="strengthBar" class="strength-bar h-full rounded-full" style="width: 0%; background-color: #e2e8f0;"></div>
                            </div>
                            <span id="strengthText" class="text-xs font-semibold text-slate-400"></span>
                        </div>
                        @error('password')
                            <p class="text-xs text-red-500 font-medium mt-1 pl-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password Input -->
                    <div class="space-y-2">
                        <label for="password_confirmation" class="block text-sm font-outfit font-bold text-slate-700">
                            <i class="bi bi-shield-lock-fill text-terracotta mr-1"></i> Konfirmasi Password
                        </label>
                        <div class="relative input-focus-glow rounded-2xl transition-all duration-200">
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                required
                                autocomplete="new-password"
                                placeholder="Ulangi password"
                                class="w-full px-4 py-3.5 pr-12 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-terracotta transition-colors"
                            >
                            <div id="matchIndicator" class="absolute right-3 top-1/2 -translate-y-1/2 hidden">
                                <i class="bi bi-check-circle-fill text-emerald-500" id="matchIcon"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        class="w-full py-3.5 rounded-full bg-gradient-to-r from-terracotta to-orange-600 hover:from-terracotta-hover hover:to-orange-700 text-white font-outfit font-extrabold text-base shadow-lg shadow-terracotta/25 hover:shadow-xl hover:shadow-terracotta/35 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 flex items-center justify-center gap-2"
                    >
                        <span>Daftar Sekarang</span>
                        <i class="bi bi-rocket-takeoff text-lg"></i>
                    </button>
                </form>

                <!-- Divider + Login Link -->
                <div class="px-8 pb-8 text-center">
                    <div class="relative mb-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-slate-200"></div>
                        </div>
                        <div class="relative flex justify-center text-xs">
                            <span class="bg-white px-4 text-slate-400 font-semibold">atau</span>
                        </div>
                    </div>
                    <p class="text-sm text-slate-500 font-medium">
                        Sudah punya akun?
                        <a href="/login" class="font-bold text-terracotta hover:underline decoration-terracotta underline-offset-2 transition-all">
                            Masuk Sekarang
                        </a>
                    </p>
                </div>
            </div>

            <!-- Back to home -->
            <div class="text-center mt-6">
                <a href="/" class="text-sm text-slate-500 font-semibold hover:text-terracotta transition-colors inline-flex items-center gap-1">
                    <i class="bi bi-arrow-left-short text-lg"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </main>

    <script>
        document.documentElement.classList.remove('dark');

        // Password Toggle
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        togglePassword?.addEventListener('click', () => {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            eyeIcon.className = isPassword ? 'bi bi-eye-slash-fill' : 'bi bi-eye-fill';
        });

        // Password Strength Meter
        passwordInput?.addEventListener('input', () => {
            const val = passwordInput.value;
            const bar = document.getElementById('strengthBar');
            const text = document.getElementById('strengthText');
            let score = 0;

            if (val.length >= 6) score++;
            if (val.length >= 10) score++;
            if (/[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;

            const levels = [
                { w: '0%', c: '#e2e8f0', t: '' },
                { w: '20%', c: '#ef4444', t: 'Lemah' },
                { w: '40%', c: '#f97316', t: 'Kurang' },
                { w: '60%', c: '#eab308', t: 'Cukup' },
                { w: '80%', c: '#22c55e', t: 'Kuat' },
                { w: '100%', c: '#16a34a', t: 'Sangat Kuat' }
            ];

            const level = levels[score] || levels[0];
            if (bar) { bar.style.width = level.w; bar.style.backgroundColor = level.c; }
            if (text) { text.textContent = level.t; text.style.color = level.c; }

            checkMatch();
        });

        // Confirm Password Match
        const confirmInput = document.getElementById('password_confirmation');
        confirmInput?.addEventListener('input', checkMatch);

        function checkMatch() {
            const indicator = document.getElementById('matchIndicator');
            const icon = document.getElementById('matchIcon');
            if (!confirmInput?.value) { indicator?.classList.add('hidden'); return; }
            indicator?.classList.remove('hidden');
            if (passwordInput?.value === confirmInput?.value) {
                icon.className = 'bi bi-check-circle-fill text-emerald-500';
            } else {
                icon.className = 'bi bi-x-circle-fill text-red-400';
            }
        }
    </script>
</body>
</html>
