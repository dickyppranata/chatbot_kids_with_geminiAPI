<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Topic;
use App\Models\ChatSession;
use App\Models\Favorite;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * GET /api/dashboard
     * Ambil data statistik ringkasan dan daftar topik untuk dashboard pengguna.
     */
    public function index(Request $request): JsonResponse
    {
        $userId = $request->user()->id;

        // Hitung data akurat dari database berdasarkan user
        $totalChats = ChatSession::where('user_id', $userId)->count();
        $totalTopics = Topic::count();
        $totalFavorites = Favorite::where('user_id', $userId)->count();

        // Ambil semua topik beserta contoh pertanyaannya (ExamplePrompts)
        $topics = Topic::with(['examplePrompts'])->get();

        return response()->json([
            'status' => 'success',
            'data'   => [
                'stats' => [
                    'total_chats'     => $totalChats,
                    'total_topics'    => $totalTopics,
                    'total_favorites' => $totalFavorites,
                ],
                'topics' => $topics,
            ],
        ]);
    }
}
