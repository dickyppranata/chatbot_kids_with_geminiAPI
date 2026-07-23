<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\SendChatRequest;
use App\Models\ChatSession;
use App\Models\ChatMessage;
use App\Models\Topic;
use App\Services\GeminiChatService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ChatController extends Controller
{
    public function __construct(
        private readonly GeminiChatService $geminiService
    ) {}

    /**
     * GET /chat
     * Render halaman chat dengan topik dari database (server-side).
     */
    public function index(): View
    {
        $topics = Topic::with('examplePrompts')->get();

        return view('chat', compact('topics'));
    }

    /**
     * POST /chat/send
     * Kirim pesan ke AI, simpan percakapan, dan kembalikan jawaban (JSON).
     */
    public function send(SendChatRequest $request): JsonResponse
    {
        $user      = Auth::user();
        $userMsg   = $request->message;
        $sessionId = $request->input('session_id');
        $topicId   = $request->input('topic_id');

        // Ambil atau buat chat session
        if ($sessionId) {
            $session = ChatSession::where('id', $sessionId)
                ->where('user_id', $user->id)
                ->firstOrFail();
        } else {
            $session = ChatSession::create([
                'user_id'  => $user->id,
                'topic_id' => $topicId,
                'title'    => mb_substr($userMsg, 0, 30) . (mb_strlen($userMsg) > 30 ? '...' : ''),
            ]);
        }

        // Simpan pesan user
        ChatMessage::create([
            'chat_session_id' => $session->id,
            'sender_type'     => 'user',
            'message'         => $userMsg,
        ]);

        // Agregasi data Eloquent ORM (Topic + Prompts Few-Shot + ExamplePrompts)
        $customSystemPrompt = null;
        $activeTopicId = $session->topic_id ?: $topicId;

        if ($activeTopicId) {
            $topic = Topic::with(['prompts', 'examplePrompts'])->find($activeTopicId);

            if ($topic) {
                $fewShotText = $topic->prompts->first()?->prompt_text;
                $examplesList = $topic->examplePrompts->pluck('question_text')->toArray();
                $examplesText = !empty($examplesList)
                    ? "\n\nContoh pertanyaan resmi pada topik ini:\n- " . implode("\n- ", $examplesList)
                    : '';

                $customSystemPrompt = "Konteks Topik Pelajaran: [{$topic->name}]\n\n"
                    . ($fewShotText ?: "Kamu adalah guru {$topic->name} yang ramah dan sabar.")
                    . $examplesText;
            }
        }

        // Bangun history percakapan sebelumnya
        $history = $this->geminiService->buildHistoryFromMessages(
            $session->messages()->orderBy('created_at')->get()
                ->slice(0, -1)
        );

        // Panggil Gemini API
        try {
            $aiResponse = $this->geminiService->sendMessage($userMsg, $history, $customSystemPrompt);
            $botReply   = $aiResponse['text'];
            $modelUsed  = $aiResponse['model'];
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ], 503);
        }

        // Simpan balasan bot
        $botMessage = ChatMessage::create([
            'chat_session_id' => $session->id,
            'sender_type'     => 'bot',
            'message'         => $botReply,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Pesan terkirim.',
            'data'    => [
                'session_id'  => $session->id,
                'model_used'  => $modelUsed,
                'bot_message' => [
                    'id'          => $botMessage->id,
                    'sender_type' => 'bot',
                    'message'     => $botReply,
                    'created_at'  => $botMessage->created_at,
                ],
            ],
        ]);
    }

    /**
     * GET /chat/history
     * Ambil daftar sesi chat (JSON).
     */
    public function history(): JsonResponse
    {
        $sessions = ChatSession::where('user_id', Auth::id())
            ->with('topic:id,name,slug')
            ->withCount('messages')
            ->orderBy('is_pinned', 'desc')
            ->orderBy('updated_at', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data'   => $sessions,
        ]);
    }

    /**
     * GET /chat/history/{sessionId}
     * Ambil semua pesan dalam satu sesi (JSON).
     */
    public function sessionMessages(int $sessionId): JsonResponse
    {
        $session = ChatSession::where('id', $sessionId)
            ->where('user_id', Auth::id())
            ->with(['topic:id,name,slug', 'messages' => function ($q) {
                $q->orderBy('created_at')->withExists(['favorites as is_favorite' => function ($query) {
                    $query->where('user_id', Auth::id());
                }]);
            }])
            ->firstOrFail();

        return response()->json([
            'status' => 'success',
            'data'   => [
                'session'  => [
                    'id'         => $session->id,
                    'title'      => $session->title,
                    'topic'      => $session->topic,
                    'is_pinned'  => $session->is_pinned,
                    'created_at' => $session->created_at,
                ],
                'messages' => $session->messages,
            ],
        ]);
    }

    /**
     * PUT /chat/history/{sessionId}
     * Ubah nama sesi (JSON).
     */
    public function renameSession(Request $request, int $sessionId): JsonResponse
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
        ], [
            'title.required' => 'Judul chat tidak boleh kosong.',
            'title.max'      => 'Judul chat maksimal 255 karakter.',
        ]);

        $session = ChatSession::where('id', $sessionId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $session->update(['title' => $request->title]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Judul chat berhasil diubah.',
            'data'    => $session,
        ]);
    }

    /**
     * DELETE /chat/history/{sessionId}
     * Hapus sesi chat (JSON).
     */
    public function deleteSession(int $sessionId): JsonResponse
    {
        $session = ChatSession::where('id', $sessionId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $session->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Riwayat chat berhasil dihapus.',
        ]);
    }

    /**
     * POST /chat/history/{sessionId}/pin
     * Toggle pin sesi (JSON).
     */
    public function togglePinSession(int $sessionId): JsonResponse
    {
        $session = ChatSession::where('id', $sessionId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $session->update(['is_pinned' => !$session->is_pinned]);

        return response()->json([
            'status'  => 'success',
            'message' => $session->is_pinned ? 'Chat berhasil disematkan di atas.' : 'Sematkan chat dilepas.',
            'data'    => $session,
        ]);
    }
}
