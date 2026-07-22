<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SendChatRequest;
use App\Models\ChatSession;
use App\Models\ChatMessage;
use App\Models\Topic;
use App\Services\GeminiChatService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function __construct(
        private readonly GeminiChatService $geminiService
    ) {}

    /**
     * POST /api/chat
     * Kirim pesan ke AI, simpan percakapan, dan kembalikan jawaban.
     * Mengagregasi data Topik, Few-Shot Prompts, dan Example Prompts dari database via Eloquent ORM.
     */
    public function send(SendChatRequest $request): JsonResponse
    {
        $user      = $request->user();
        $userMsg   = $request->message;
        $sessionId = $request->input('session_id');
        $topicId   = $request->input('topic_id');

        // Ambil atau buat chat session
        if ($sessionId) {
            $session = ChatSession::where('id', $sessionId)
                ->where('user_id', $user->id)
                ->firstOrFail();
        } else {
            // Buat sesi baru, gunakan 30 karakter pertama pesan sebagai judul
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

        // ------------------------------------------------------------------
        // AGREGASI DATA ELOQUENT ORM (Topic + Prompts Few-Shot + ExamplePrompts)
        // ------------------------------------------------------------------
        $customSystemPrompt = null;
        $activeTopicId = $session->topic_id ?: $topicId;

        if ($activeTopicId) {
            $topic = Topic::with(['prompts', 'examplePrompts'])->find($activeTopicId);

            if ($topic) {
                // 1. Ambil teks Few-Shot Prompt dari relasi prompts
                $fewShotText = $topic->prompts->first()?->prompt_text;

                // 2. Ambil daftar contoh pertanyaan dari relasi examplePrompts
                $examplesList = $topic->examplePrompts->pluck('question_text')->toArray();
                $examplesText = !empty($examplesList)
                    ? "\n\nContoh pertanyaan resmi pada topik ini:\n- " . implode("\n- ", $examplesList)
                    : '';

                // 3. Agregasikan seluruh context database untuk dimasukkan ke instruksi AI
                $customSystemPrompt = "Konteks Topik Pelajaran: [{$topic->name}]\n\n"
                    . ($fewShotText ?: "Kamu adalah guru {$topic->name} yang ramah dan sabar.")
                    . $examplesText;
            }
        }

        // Bangun history percakapan sebelumnya untuk konteks Gemini
        $history = $this->geminiService->buildHistoryFromMessages(
            $session->messages()->orderBy('created_at')->get()
                ->slice(0, -1) // Kecualikan pesan user yang baru saja disimpan
        );

        // Panggil Gemini API dengan instruksi Few-Shot teragregasi dari Eloquent ORM
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
     * GET /api/chat/history
     * Ambil daftar semua sesi chat milik user yang sedang login.
     */
    public function history(Request $request): JsonResponse
    {
        $sessions = ChatSession::where('user_id', $request->user()->id)
            ->with('topic:id,name,slug')
            ->withCount('messages')
            ->latest()
            ->get();

        return response()->json([
            'status' => 'success',
            'data'   => $sessions,
        ]);
    }

    /**
     * GET /api/chat/history/{session_id}
     * Ambil semua pesan dalam satu sesi chat tertentu.
     */
    public function sessionMessages(Request $request, int $sessionId): JsonResponse
    {
        $session = ChatSession::where('id', $sessionId)
            ->where('user_id', $request->user()->id)
            ->with(['topic:id,name,slug', 'messages' => fn ($q) => $q->orderBy('created_at')])
            ->firstOrFail();

        return response()->json([
            'status' => 'success',
            'data'   => [
                'session'  => [
                    'id'         => $session->id,
                    'title'      => $session->title,
                    'topic'      => $session->topic,
                    'created_at' => $session->created_at,
                ],
                'messages' => $session->messages,
            ],
        ]);
    }
}
