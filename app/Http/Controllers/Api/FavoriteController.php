<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\ChatMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    /**
     * GET /api/favorites
     * Ambil semua jawaban yang difavoritkan oleh user beserta pertanyaan sebelumnya.
     */
    public function index(Request $request): JsonResponse
    {
        $favorites = Favorite::where('user_id', $request->user()->id)
            ->with(['chatMessage.chatSession.topic'])
            ->latest()
            ->get();

        $data = $favorites->map(function ($fav) {
            $botMessage = $fav->chatMessage;
            
            // Dapatkan pertanyaan user yang memicu jawaban bot ini (pesan sebelumnya dalam sesi yang sama)
            $userQuestion = ChatMessage::where('chat_session_id', $botMessage->chat_session_id)
                ->where('sender_type', 'user')
                ->where('id', '<', $botMessage->id)
                ->orderBy('id', 'desc')
                ->first();

            return [
                'id'              => $fav->id,
                'chat_message_id' => $botMessage->id,
                'chat_session_id' => $botMessage->chat_session_id,
                'topic_name'      => $botMessage->chatSession->topic?->name ?? 'Umum',
                'question'        => $userQuestion ? $userQuestion->message : 'Pertanyaan',
                'answer'          => $botMessage->message,
                'created_at'      => $fav->created_at,
            ];
        });

        return response()->json([
            'status' => 'success',
            'data'   => $data,
        ]);
    }

    /**
     * POST /api/favorites/toggle
     * Tambah atau hapus jawaban dari daftar favorit.
     */
    public function toggle(Request $request): JsonResponse
    {
        $request->validate([
            'chat_message_id' => ['required', 'integer', 'exists:chat_messages,id'],
        ]);

        // Guardrail: Pastikan pesan bot ini berada dalam sesi milik user yang bersangkutan
        $message = ChatMessage::where('id', $request->chat_message_id)
            ->where('sender_type', 'bot')
            ->whereHas('chatSession', function ($q) use ($request) {
                $q->where('user_id', $request->user()->id);
            })
            ->firstOrFail();

        $favorite = Favorite::where('user_id', $request->user()->id)
            ->where('chat_message_id', $message->id)
            ->first();

        if ($favorite) {
            $favorite->delete();
            return response()->json([
                'status'      => 'success',
                'message'     => 'Jawaban dihapus dari favorit.',
                'is_favorite' => false,
            ]);
        } else {
            Favorite::create([
                'user_id'         => $request->user()->id,
                'chat_message_id' => $message->id,
            ]);
            return response()->json([
                'status'      => 'success',
                'message'     => 'Jawaban ditambahkan ke favorit.',
                'is_favorite' => true,
            ]);
        }
    }
}
