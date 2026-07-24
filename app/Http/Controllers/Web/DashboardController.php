<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ChatSession;
use App\Models\Favorite;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * GET /dashboard
     * Render halaman dashboard dengan data statistik dan topik langsung dari database (server-side).
     */
    public function index(): View
    {
        $userId = Auth::id();

        // Agregasi statistik user
        $stats = [
            'total_chats'     => ChatSession::where('user_id', $userId)->count(),
            'total_topics'    => Topic::count(),
            'total_favorites' => Favorite::where('user_id', $userId)->count(),
        ];

        // Ambil topik beserta contoh pertanyaan
        $topics = Topic::with('examplePrompts')->get();

        // Ambil recent chat sessions (4 terakhir)
        $recentChats = ChatSession::where('user_id', $userId)
            ->with('topic:id,name,slug')
            ->withCount('messages')
            ->orderBy('updated_at', 'desc')
            ->take(4)
            ->get();

        return view('user.dashboard', compact('stats', 'topics', 'recentChats'));
    }
}
