<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Daftar akun AI Buddy - Mulai belajar interaktif bersama Guru AI Pintar">
    <title>Daftar - AI Buddy</title>

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
        @keyframes confetti-pop {
            0% { transform: scale(0.5); opacity: 0; }
            50% { transform: scale(1.1); opacity: 1; }
            100% { transform: scale(1); opacity: 1; }
        }
        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-float-delay { animation: float 6s ease-in-out 2s infinite; }
        .animate-fade-in-up { animation: fadeInUp 0.6s ease-out both; }
        .input-focus-glow:focus-within {
            box-shadow: 0 0 0 3px rgba(194, 65, 12, 0.15), 0 0 20px rgba(194, 65, 12, 0.08);
        }
        .strength-bar { transition: width 0.4s ease, background-color 0.4s ease; }
        .role-option { transition: all 0.2s ease; }
        .role-option.selected {
            border-color: #c2410c;
            background: rgba(194, 65, 12, 0.06);
            box-shadow: 0 0 0 2px rgba(194, 65, 12, 0.2);
        }
    </style>
</head>
<body class="bg-cream-bg text-slate-900 min-h-screen font-sans antialiased">

    <!-- Background Ambient Glowing Orbs -->
    <div class="fixed top-[-100px] right-[-100px] w-[500px] h-[500px] bg-terracotta/10 rounded-full filter blur-[120px] -z-10 animate-float pointer-events-none"></div>
    <div class="fixed bottom-[-50px] left-[-50px] w-[450px] h-[450px] bg-amber-500/10 rounded-full filter blur-[100px] -z-10 animate-float-delay pointer-events-none"></div>

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

                <!-- Form -->
                <form id="registerForm" class="px-8 pb-8 pt-6 space-y-5">
                    <meta name="csrf-token" content="{{ csrf_token() }}">

                    <!-- Global Error Alert -->
                    <div id="globalError" class="hidden px-4 py-3 rounded-2xl bg-red-50 border border-red-200 text-red-700 text-sm font-medium flex items-center gap-2">
                        <i class="bi bi-exclamation-triangle-fill text-red-500"></i>
                        <span id="globalErrorText"></span>
                    </div>

                    <!-- Success Alert -->
                    <div id="successAlert" class="hidden px-4 py-3 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-medium flex items-center gap-2" style="animation: confetti-pop 0.5s ease-out both;">
                        <i class="bi bi-check-circle-fill text-emerald-500"></i>
                        <span id="successText"></span>
                    </div>

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
                                class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-terracotta transition-colors"
                            >
                        </div>
                        <p id="nameError" class="hidden text-xs text-red-500 font-medium mt-1 pl-1"></p>
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
                                class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-terracotta transition-colors"
                            >
                        </div>
                        <p id="emailError" class="hidden text-xs text-red-500 font-medium mt-1 pl-1"></p>
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
                                class="w-full px-4 py-3.5 pr-12 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-terracotta transition-colors"
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
                        <p id="passwordError" class="hidden text-xs text-red-500 font-medium mt-1 pl-1"></p>
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
                        <p id="password_confirmationError" class="hidden text-xs text-red-500 font-medium mt-1 pl-1"></p>
                    </div>

                    <!-- Role Selection -->
                    <div class="space-y-2">
                        <label class="block text-sm font-outfit font-bold text-slate-700">
                            <i class="bi bi-stars text-terracotta mr-1"></i> Daftar Sebagai
                        </label>
                        <div class="grid grid-cols-2 gap-3">
                            <button type="button" id="roleAnak" data-role="anak" class="role-option selected px-4 py-3 rounded-2xl bg-white border-2 border-terracotta text-center cursor-pointer">
                                <div class="text-2xl mb-1">🧒</div>
                                <p class="text-sm font-outfit font-bold text-slate-800">Anak</p>
                                <p class="text-[10px] text-slate-400 font-medium">Belajar & bertanya</p>
                            </button>
                            <button type="button" id="roleAdmin" data-role="admin" class="role-option px-4 py-3 rounded-2xl bg-white border-2 border-slate-200 text-center cursor-pointer">
                                <div class="text-2xl mb-1">👨‍🏫</div>
                                <p class="text-sm font-outfit font-bold text-slate-800">Admin</p>
                                <p class="text-[10px] text-slate-400 font-medium">Kelola platform</p>
                            </button>
                        </div>
                        <input type="hidden" id="role" name="role" value="anak">
                        <p id="roleError" class="hidden text-xs text-red-500 font-medium mt-1 pl-1"></p>
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        id="submitBtn"
                        class="w-full py-3.5 rounded-full bg-gradient-to-r from-terracotta to-orange-600 hover:from-terracotta-hover hover:to-orange-700 text-white font-outfit font-extrabold text-base shadow-lg shadow-terracotta/25 hover:shadow-xl hover:shadow-terracotta/35 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 flex items-center justify-center gap-2 disabled:opacity-60 disabled:cursor-not-allowed disabled:hover:translate-y-0"
                    >
                        <span id="btnText">Daftar Sekarang</span>
                        <i class="bi bi-rocket-takeoff text-lg" id="btnIcon"></i>
                        <svg id="btnSpinner" class="hidden animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
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

            <!-- Back to home link -->
            <div class="text-center mt-6">
                <a href="/" class="text-sm text-slate-500 font-semibold hover:text-terracotta transition-colors inline-flex items-center gap-1">
                    <i class="bi bi-arrow-left-short text-lg"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </main>

    <script>
        // Auto-redirect if already logged in
        if (localStorage.getItem('access_token')) {
            window.location.href = '/dashboard';
        }

        // Force Light Mode
        document.documentElement.classList.remove('dark');
        localStorage.removeItem('theme');

        // Password Toggle
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        togglePassword.addEventListener('click', () => {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            eyeIcon.className = isPassword ? 'bi bi-eye-slash-fill' : 'bi bi-eye-fill';
        });

        // Password Strength Indicator
        const strengthBar = document.getElementById('strengthBar');
        const strengthText = document.getElementById('strengthText');

        passwordInput.addEventListener('input', () => {
            const val = passwordInput.value;
            let strength = 0;
            if (val.length >= 6) strength++;
            if (val.length >= 10) strength++;
            if (/[A-Z]/.test(val)) strength++;
            if (/[0-9]/.test(val)) strength++;
            if (/[^A-Za-z0-9]/.test(val)) strength++;

            const levels = [
                { width: '0%', color: '#e2e8f0', text: '' },
                { width: '20%', color: '#ef4444', text: 'Sangat Lemah' },
                { width: '40%', color: '#f97316', text: 'Lemah' },
                { width: '60%', color: '#eab308', text: 'Cukup' },
                { width: '80%', color: '#22c55e', text: 'Kuat' },
                { width: '100%', color: '#10b981', text: 'Sangat Kuat' },
            ];

            const level = val.length === 0 ? levels[0] : levels[Math.min(strength, 5)];
            strengthBar.style.width = level.width;
            strengthBar.style.backgroundColor = level.color;
            strengthText.textContent = level.text;
            strengthText.style.color = level.color;

            checkPasswordMatch();
        });

        // Password Match Check
        const confirmInput = document.getElementById('password_confirmation');
        const matchIndicator = document.getElementById('matchIndicator');
        const matchIcon = document.getElementById('matchIcon');

        function checkPasswordMatch() {
            const pw = passwordInput.value;
            const confirm = confirmInput.value;

            if (confirm.length === 0) {
                matchIndicator.classList.add('hidden');
                return;
            }

            matchIndicator.classList.remove('hidden');
            if (pw === confirm) {
                matchIcon.className = 'bi bi-check-circle-fill text-emerald-500';
            } else {
                matchIcon.className = 'bi bi-x-circle-fill text-red-400';
            }
        }

        confirmInput.addEventListener('input', checkPasswordMatch);

        // Role Selection
        const roleAnakBtn = document.getElementById('roleAnak');
        const roleAdminBtn = document.getElementById('roleAdmin');
        const roleInput = document.getElementById('role');

        [roleAnakBtn, roleAdminBtn].forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.role-option').forEach(el => {
                    el.classList.remove('selected');
                    el.classList.remove('border-terracotta');
                    el.classList.add('border-slate-200');
                });
                btn.classList.add('selected');
                btn.classList.remove('border-slate-200');
                btn.classList.add('border-terracotta');
                roleInput.value = btn.dataset.role;
            });
        });

        // Clear field error on input
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('input', () => {
                const errorEl = document.getElementById(input.id + 'Error');
                if (errorEl) {
                    errorEl.classList.add('hidden');
                    errorEl.textContent = '';
                }
                document.getElementById('globalError').classList.add('hidden');
            });
        });

        // Form Submit
        const registerForm = document.getElementById('registerForm');
        const submitBtn = document.getElementById('submitBtn');
        const btnText = document.getElementById('btnText');
        const btnIcon = document.getElementById('btnIcon');
        const btnSpinner = document.getElementById('btnSpinner');

        registerForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            // Reset errors
            document.querySelectorAll('[id$="Error"]').forEach(el => {
                el.classList.add('hidden');
                el.textContent = '';
            });
            document.getElementById('globalError').classList.add('hidden');
            document.getElementById('successAlert').classList.add('hidden');

            // Client-side password match validation
            if (passwordInput.value !== confirmInput.value) {
                const errorEl = document.getElementById('password_confirmationError');
                errorEl.textContent = 'Konfirmasi password tidak cocok.';
                errorEl.classList.remove('hidden');
                return;
            }

            // Disable button and show spinner
            submitBtn.disabled = true;
            btnText.textContent = 'Mendaftarkan...';
            btnIcon.classList.add('hidden');
            btnSpinner.classList.remove('hidden');

            const formData = {
                name: document.getElementById('name').value,
                email: document.getElementById('email').value,
                password: passwordInput.value,
                password_confirmation: confirmInput.value,
                role: roleInput.value,
            };

            try {
                const response = await fetch('/api/auth/register', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(formData),
                });

                const data = await response.json();

                if (response.ok && data.status === 'success') {
                    // Store token
                    localStorage.setItem('access_token', data.data.access_token);
                    localStorage.setItem('user', JSON.stringify(data.data.user));

                    // Show success
                    document.getElementById('successAlert').classList.remove('hidden');
                    document.getElementById('successText').textContent = '🎉 Registrasi berhasil! Mengalihkan...';

                    // Redirect to dashboard
                    setTimeout(() => {
                        window.location.href = '/dashboard';
                    }, 1500);
                } else if (response.status === 422 && data.errors) {
                    // Validation errors
                    for (const [field, messages] of Object.entries(data.errors)) {
                        const errorEl = document.getElementById(field + 'Error');
                        if (errorEl) {
                            errorEl.textContent = messages[0];
                            errorEl.classList.remove('hidden');
                        }
                    }
                    resetButton();
                } else {
                    document.getElementById('globalError').classList.remove('hidden');
                    document.getElementById('globalErrorText').textContent = data.message || 'Terjadi kesalahan. Silakan coba lagi.';
                    resetButton();
                }
            } catch (error) {
                document.getElementById('globalError').classList.remove('hidden');
                document.getElementById('globalErrorText').textContent = 'Terjadi kesalahan jaringan. Silakan coba lagi.';
                resetButton();
            }
        });

        function resetButton() {
            submitBtn.disabled = false;
            btnText.textContent = 'Daftar Sekarang';
            btnIcon.classList.remove('hidden');
            btnSpinner.classList.add('hidden');
        }
    </script>
</body>
</html>
