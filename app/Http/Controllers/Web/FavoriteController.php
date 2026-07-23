<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use App\Models\Favorite;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class FavoriteController extends Controller
{
    /**
     * GET /favorites
     * Render halaman favorit dengan data langsung dari database (server-side).
     */
    public function index(): View
    {
        $favorites = Favorite::where('user_id', Auth::id())
            ->with(['chatMessage.chatSession.topic'])
            ->latest()
            ->get();

        $data = $favorites->map(function ($fav) {
            $botMessage = $fav->chatMessage;

            // Dapatkan pertanyaan user yang memicu jawaban bot ini
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

        return view('favorites', ['favorites' => $data]);
    }

    /**
     * POST /favorites/toggle
     * Tambah/hapus favorit (JSON).
     */
    public function toggle(Request $request): JsonResponse
    {
        $request->validate([
            'chat_message_id' => ['required', 'integer', 'exists:chat_messages,id'],
        ]);

        // Guardrail: pastikan pesan bot ada di sesi milik user
        $message = ChatMessage::where('id', $request->chat_message_id)
            ->where('sender_type', 'bot')
            ->whereHas('chatSession', function ($q) {
                $q->where('user_id', Auth::id());
            })
            ->firstOrFail();

        $favorite = Favorite::where('user_id', Auth::id())
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
                'user_id'         => Auth::id(),
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
