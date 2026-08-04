@extends('layouts.admin')

@section('title', 'Statistik Analitik - AI Buddy Admin')
@section('page_heading', 'Statistik Analitik & Pemantauan API')
@section('page_subheading', 'Pantau keaktifan percakapan siswa, distribusi minat topik pelajaran, serta estimasi kuota Gemini API')

@section('content')
<div class="space-y-6 animate-fade-in">

    <!-- Top Metric Cards Grid (4 Cards) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Card 1: Gemini API RPD Quota -->
        <div class="bg-white border border-slate-200/80 rounded-3xl p-5 shadow-sm space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-outfit font-bold text-slate-400 uppercase tracking-wider">Quota API Gemini (RPD)</span>
                <div class="w-9 h-9 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center text-lg font-bold">
                    <i class="bi bi-cpu-fill"></i>
                </div>
            </div>
            <div>
                <h3 class="font-outfit font-black text-2xl text-slate-900 leading-tight">
                    {{ number_format($todayApiRequests) }} <span class="text-xs font-bold text-slate-400">/ {{ number_format($dailyRpdLimit) }} RPD</span>
                </h3>
                <div class="mt-2.5 space-y-1">
                    <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                        <div class="bg-gradient-to-r from-amber-500 to-terracotta h-full rounded-full transition-all duration-500" style="width: {{ max(5, $rpdPercentage) }}%"></div>
                    </div>
                    <div class="flex items-center justify-between text-[10px] font-bold text-slate-500">
                        <span>Hari ini: {{ $rpdPercentage }}%</span>
                        <span class="text-emerald-600 font-extrabold"><i class="bi bi-shield-check"></i> Status Normal</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: Estimated Token Usage -->
        <div class="bg-white border border-slate-200/80 rounded-3xl p-5 shadow-sm space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-outfit font-bold text-slate-400 uppercase tracking-wider">Estimasi Token</span>
                <div class="w-9 h-9 rounded-2xl bg-purple-100 text-purple-600 flex items-center justify-center text-lg font-bold">
                    <i class="bi bi-code-slash"></i>
                </div>
            </div>
            <div>
                <h3 class="font-outfit font-black text-2xl text-slate-900 leading-tight">
                    {{ number_format($estimatedTokens) }} <span class="text-xs font-bold text-purple-600">Tokens</span>
                </h3>
                <p class="text-[11px] font-medium text-slate-500 mt-1">
                    Total {{ number_format($totalCharacters) }} karakter obrolan
                </p>
            </div>
        </div>

        <!-- Card 3: Total Chat Sessions -->
        <div class="bg-white border border-slate-200/80 rounded-3xl p-5 shadow-sm space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-outfit font-bold text-slate-400 uppercase tracking-wider">Total Sesi Chat</span>
                <div class="w-9 h-9 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center text-lg font-bold">
                    <i class="bi bi-chat-left-text-fill"></i>
                </div>
            </div>
            <div>
                <h3 class="font-outfit font-black text-2xl text-slate-900 leading-tight">
                    {{ number_format($totalSessions) }} <span class="text-xs font-bold text-slate-400">Sesi</span>
                </h3>
                <p class="text-[11px] font-medium text-slate-500 mt-1">
                    Total {{ number_format($totalMessages) }} pesan terkirim
                </p>
            </div>
        </div>

        <!-- Card 4: Favorited Messages -->
        <div class="bg-white border border-slate-200/80 rounded-3xl p-5 shadow-sm space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-outfit font-bold text-slate-400 uppercase tracking-wider">Pesan Difavoritkan</span>
                <div class="w-9 h-9 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-lg font-bold">
                    <i class="bi bi-star-fill"></i>
                </div>
            </div>
            <div>
                <h3 class="font-outfit font-black text-2xl text-slate-900 leading-tight">
                    {{ number_format($totalFavorites) }} <span class="text-xs font-bold text-emerald-600">Favorit</span>
                </h3>
                <p class="text-[11px] font-medium text-slate-500 mt-1">
                    Dari {{ number_format($totalActiveStudents) }} siswa aktif
                </p>
            </div>
        </div>

    </div>

    <!-- Responsive Charts Grid (Line Chart & Donut Chart) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 w-full">

        <!-- Chart 1: 7-Day Conversation Trend (Line Chart - 7 cols) -->
        <div class="lg:col-span-7 bg-white border border-slate-200/80 rounded-3xl p-5 md:p-6 shadow-sm min-w-0 w-full flex flex-col justify-between space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div>
                    <h3 class="font-outfit font-extrabold text-base text-slate-900 flex items-center gap-2">
                        <i class="bi bi-graph-up-arrow text-terracotta"></i> Tren Percakapan (7 Hari Terakhir)
                    </h3>
                    <p class="text-xs text-slate-500 font-medium mt-0.5">Jumlah sesi percakapan baru yang dibuat siswa setiap hari</p>
                </div>
            </div>

            <div class="relative w-full h-[280px] sm:h-[320px]">
                <canvas id="trendChart"></canvas>
            </div>
        </div>

        <!-- Chart 2: Topic Interest Distribution (Donut Chart - 5 cols) -->
        <div class="lg:col-span-5 bg-white border border-slate-200/80 rounded-3xl p-5 md:p-6 shadow-sm min-w-0 w-full flex flex-col justify-between space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div>
                    <h3 class="font-outfit font-extrabold text-base text-slate-900 flex items-center gap-2">
                        <i class="bi bi-pie-chart-fill text-purple-600"></i> Distribusi Minat Topik
                    </h3>
                    <p class="text-xs text-slate-500 font-medium mt-0.5">Persentase sebaran sesi obrolan per topik</p>
                </div>
            </div>

            <div class="relative w-full h-[280px] sm:h-[320px] flex items-center justify-center">
                <canvas id="topicChart"></canvas>
            </div>
        </div>

    </div>

    <!-- Topic Popularity Ranking Table -->
    <div class="bg-white border border-slate-200/80 rounded-3xl shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100">
            <h3 class="font-outfit font-extrabold text-base text-slate-900 flex items-center gap-2">
                <i class="bi bi-trophy-fill text-amber-500"></i> Peringkat Keaktifan Topik Pelajaran
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs font-medium">
                <thead class="bg-slate-50 border-b border-slate-200/80 text-slate-500 font-bold uppercase tracking-wider">
                    <tr>
                        <th class="p-4">Peringkat & Topik</th>
                        <th class="p-4">Slug URL</th>
                        <th class="p-4 text-center">Jumlah Sesi Chat</th>
                        <th class="p-4 text-center">Persentase Minat</th>
                        <th class="p-4 text-center">Status Keaktifan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @php
                        $sortedTopics = $topics->sortByDesc('chat_sessions_count')->values();
                        $colors = ['#d95f3b', '#8b5cf6', '#10b981', '#f59e0b', '#3b82f6'];
                    @endphp

                    @forelse($sortedTopics as $index => $topic)
                        @php
                            $percentage = $totalSessions > 0 ? round(($topic->chat_sessions_count / $totalSessions) * 100, 1) : 0;
                            $badgeColor = $colors[$index % count($colors)];
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <span class="w-7 h-7 rounded-xl font-bold flex items-center justify-center text-xs text-white shadow-sm" style="background-color: {{ $badgeColor }}">
                                        #{{ $index + 1 }}
                                    </span>
                                    <span class="font-outfit font-bold text-sm text-slate-900">
                                        {{ $topic->name }}
                                    </span>
                                </div>
                            </td>
                            <td class="p-4 font-mono text-[11px] text-slate-600">
                                {{ $topic->slug }}
                            </td>
                            <td class="p-4 text-center font-bold text-slate-900 text-sm">
                                {{ number_format($topic->chat_sessions_count) }}
                            </td>
                            <td class="p-4 text-center">
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-800">
                                    {{ $percentage }}%
                                </span>
                            </td>
                            <td class="p-4 text-center">
                                @if($topic->chat_sessions_count > 0)
                                    <span class="px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 text-[11px] font-bold">
                                        🔥 Aktif Ditanyakan
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-500 text-[11px] font-medium">
                                        Belum Ada Chat
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-slate-400 font-medium">
                                Belum ada topik pelajaran.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Chart.js CDN & Refactored Responsive Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Data dari Backend Controller
        const trendDates = @json($trendDates);
        const trendCounts = @json($trendCounts);
        const topicNames = @json($topicNames);
        const topicCounts = @json($topicCounts);

        // Color Palette
        const colors = ['#d95f3b', '#8b5cf6', '#10b981', '#f59e0b', '#3b82f6'];

        // 1. Render Line Chart (Tren Percakapan 7 Hari)
        const canvasTrend = document.getElementById('trendChart');
        if (canvasTrend) {
            const ctxTrend = canvasTrend.getContext('2d');
            
            // Gradient Fill
            const gradientFill = ctxTrend.createLinearGradient(0, 0, 0, 300);
            gradientFill.addColorStop(0, 'rgba(217, 95, 59, 0.35)');
            gradientFill.addColorStop(1, 'rgba(217, 95, 59, 0.0)');

            new Chart(ctxTrend, {
                type: 'line',
                data: {
                    labels: trendDates,
                    datasets: [{
                        label: 'Sesi Chat Baru',
                        data: trendCounts,
                        borderColor: '#d95f3b',
                        backgroundColor: gradientFill,
                        fill: true,
                        tension: 0.35,
                        borderWidth: 3,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#d95f3b',
                        pointBorderWidth: 3,
                        pointRadius: 5,
                        pointHoverRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    layout: {
                        padding: { top: 10, bottom: 10, left: 5, right: 15 }
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            titleFont: { family: 'Outfit', size: 12, weight: 'bold' },
                            bodyFont: { family: 'Outfit', size: 12 },
                            padding: 10,
                            cornerRadius: 12,
                            displayColors: false
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { font: { family: 'Outfit', size: 11, weight: '600' }, color: '#64748b' }
                        },
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(226, 232, 240, 0.8)' },
                            ticks: { stepSize: 1, precision: 0, font: { family: 'Outfit', size: 11, weight: '600' }, color: '#64748b' }
                        }
                    }
                }
            });
        }

        // 2. Render Donut Chart (Distribusi Topik)
        const canvasTopic = document.getElementById('topicChart');
        if (canvasTopic) {
            const ctxTopic = canvasTopic.getContext('2d');
            const hasData = !topicCounts.every(c => c === 0);

            new Chart(ctxTopic, {
                type: 'doughnut',
                data: {
                    labels: topicNames,
                    datasets: [{
                        data: hasData ? topicCounts : [1],
                        backgroundColor: hasData ? colors.slice(0, topicNames.length) : ['#cbd5e1'],
                        borderWidth: 2,
                        borderColor: '#ffffff',
                        hoverOffset: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    layout: {
                        padding: { top: 10, bottom: 10, left: 10, right: 10 }
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                font: { family: 'Outfit', size: 11, weight: '600' },
                                color: '#334155',
                                padding: 14,
                                usePointStyle: true,
                                pointStyle: 'circle'
                            }
                        },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            titleFont: { family: 'Outfit', size: 12, weight: 'bold' },
                            bodyFont: { family: 'Outfit', size: 12 },
                            padding: 10,
                            cornerRadius: 12
                        }
                    },
                    cutout: '68%'
                }
            });
        }
    });
</script>
@endsection
