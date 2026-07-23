<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Masuk ke AI Buddy - Sahabat Belajar Interaktif untuk Anak Indonesia">
    <title>Masuk - AI Buddy</title>

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
                <a href="/register" class="px-5 py-2.5 rounded-full bg-gradient-to-r from-terracotta to-orange-600 text-white font-outfit font-bold text-sm shadow-md shadow-terracotta/20 hover:shadow-lg hover:shadow-terracotta/30 hover:-translate-y-0.5 transition-all no-underline">Daftar Akun</a>
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
                        <i class="bi bi-person-fill text-3xl"></i>
                    </div>
                    <h1 class="font-outfit font-extrabold text-2xl md:text-3xl text-slate-900">
                        Selamat Datang Kembali!
                    </h1>
                    <p class="text-sm text-slate-500 font-medium mt-2">
                        Masuk ke akun AI Buddy untuk mulai belajar bersama Kakak AI
                    </p>
                </div>

                <!-- Form (Standard Laravel POST) -->
                <form action="/login" method="POST" class="px-8 pb-8 pt-6 space-y-5">
                    @csrf

                    <!-- Global Error Alert (from server validation) -->
                    @if($errors->any())
                        <div class="px-4 py-3 rounded-2xl bg-red-50 border border-red-200 text-red-700 text-sm font-medium flex items-center gap-2">
                            <i class="bi bi-exclamation-triangle-fill text-red-500"></i>
                            <span>{{ $errors->first() }}</span>
                        </div>
                    @endif

                    <!-- Success Alert (from session flash) -->
                    @if(session('success'))
                        <div class="px-4 py-3 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-medium flex items-center gap-2">
                            <i class="bi bi-check-circle-fill text-emerald-500"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

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
                                autocomplete="current-password"
                                placeholder="Masukkan password"
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
                        @error('password')
                            <p class="text-xs text-red-500 font-medium mt-1 pl-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="remember" id="remember" class="w-4 h-4 text-terracotta border-slate-300 rounded focus:ring-terracotta">
                        <label for="remember" class="text-sm text-slate-600 font-medium cursor-pointer">Ingat saya</label>
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        class="w-full py-3.5 rounded-full bg-gradient-to-r from-terracotta to-orange-600 hover:from-terracotta-hover hover:to-orange-700 text-white font-outfit font-extrabold text-base shadow-lg shadow-terracotta/25 hover:shadow-xl hover:shadow-terracotta/35 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 flex items-center justify-center gap-2"
                    >
                        <span>Masuk Sekarang</span>
                        <i class="bi bi-arrow-right-short text-xl"></i>
                    </button>
                </form>

                <!-- Divider + Register Link -->
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
                        Belum punya akun?
                        <a href="/register" class="font-bold text-terracotta hover:underline decoration-terracotta underline-offset-2 transition-all">
                            Daftar Sekarang
                        </a>
                    </p>
                </div>
            </div>

            <!-- Back to home link -->
            <div class="text-center mt-6">
                <a href="/" class="text-sm text-slate-500 font-semibold hover:text-terracotta transition-colors inline-flex items-center gap-1">
                    <i class="bi bi-arrow-left-short text-lg"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </main>

    <script>
        // Force Light Mode
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
    </script>
</body>
</html>
