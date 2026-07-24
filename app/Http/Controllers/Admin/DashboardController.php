<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use App\Models\ChatSession;
use App\Models\ExamplePrompt;
use App\Models\Favorite;
use App\Models\Prompt;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * GET /admin/dashboard
     * Tampilkan dashboard ringkasan statistik dan aktivitas sistem untuk Admin.
     */
    public function index(): View
    {
        // 1. Stat Ringkasan Sistem
        $stats = [
            'total_users'          => User::where('role', 'anak')->count(),
            'total_admins'         => User::where('role', 'admin')->count(),
            'total_topics'         => Topic::count(),
            'total_prompts'        => Prompt::count(),
            'total_example_prompts'=> ExamplePrompt::count(),
            'total_sessions'       => ChatSession::count(),
            'total_messages'       => ChatMessage::count(),
            'total_favorites'      => Favorite::count(),
        ];

        // 2. Topik Terpopuler (Diurutkan dari sesi terbanyak)
        $popularTopics = Topic::withCount(['chatSessions', 'examplePrompts'])
            ->orderBy('chat_sessions_count', 'desc')
            ->take(5)
            ->get();

        // 3. Pengguna Terbaru (Siswa 10-14th)
        $recentUsers = User::where('role', 'anak')
            ->withCount('chatSessions')
            ->latest()
            ->take(5)
            ->get();

        // 4. Sesi Chat Terbaru Sistem
        $recentSessions = ChatSession::with(['user:id,name,email', 'topic:id,name,slug'])
            ->withCount('messages')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'popularTopics',
            'recentUsers',
            'recentSessions'
        ));
    }
}
