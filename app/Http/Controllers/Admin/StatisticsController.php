<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use App\Models\ChatSession;
use App\Models\Favorite;
use App\Models\Topic;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class StatisticsController extends Controller
{
    /**
     * Tampilkan halaman statistik analitik & pemantauan API.
     */
    public function index(): View
    {
        $today = Carbon::today();

        // 1. Penggunaan API Gemini (Requests Per Day / RPD)
        // Setiap pesan balasan bot merupakan 1 panggilan API Gemini
        $todayApiRequests = ChatMessage::where('sender_type', 'bot')
            ->whereDate('created_at', $today)
            ->count();

        $dailyRpdLimit = 1500; // Standar Tier Gratis Gemini API (1.500 RPD)
        $rpdPercentage = min(100, round(($todayApiRequests / $dailyRpdLimit) * 100, 1));

        // 2. Estimasi Token & Karakter
        // Perhitungan: 1 Token ≈ 4 Karakter
        $totalCharacters = ChatMessage::all()->sum(fn($m) => strlen($m->message));
        $estimatedTokens = round($totalCharacters / 4);

        // 3. Tren Percakapan 7 Hari Terakhir (Line Chart)
        $trendDates = [];
        $trendCounts = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $trendDates[] = $date->locale('id')->isoFormat('dd, D MMM');
            $trendCounts[] = ChatSession::whereDate('created_at', $date)->count();
        }

        // 4. Distribusi Minat Topik Pelajaran (Donut Chart)
        $topics = Topic::withCount('chatSessions')->get();
        $topicNames = $topics->pluck('name')->toArray();
        $topicCounts = $topics->pluck('chat_sessions_count')->toArray();

        // 5. Metrik Tambahan
        $totalFavorites = Favorite::count();
        $totalActiveStudents = User::where('role', 'anak')->whereHas('chatSessions')->count();
        $totalSessions = ChatSession::count();
        $totalMessages = ChatMessage::count();

        return view('admin.statistics', compact(
            'todayApiRequests',
            'dailyRpdLimit',
            'rpdPercentage',
            'totalCharacters',
            'estimatedTokens',
            'trendDates',
            'trendCounts',
            'topics',
            'topicNames',
            'topicCounts',
            'totalFavorites',
            'totalActiveStudents',
            'totalSessions',
            'totalMessages'
        ));
    }
}
