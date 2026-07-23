<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Topic;
use Illuminate\Http\JsonResponse;

class TopicController extends Controller
{
    /**
     * GET /topics
     * Mengembalikan daftar semua topik beserta contoh pertanyaan (JSON).
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
