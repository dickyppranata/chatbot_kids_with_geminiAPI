<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Topic;
use Illuminate\Http\JsonResponse;

class TopicController extends Controller
{
    /**
     * GET /api/topics
     * Ambil semua topik belajar beserta contoh pertanyaan (examplePrompts).
     */
    public function index(): JsonResponse
    {
        $topics = Topic::with('examplePrompts')->get();

        return response()->json([
            'status' => 'success',
            'data'   => $topics,
        ]);
    }
}
