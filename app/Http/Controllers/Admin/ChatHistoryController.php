<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatSession;
use App\Models\ChatMessage;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ChatHistoryController extends Controller
{
    /**
     * Tampilkan daftar siswa pengelompokan riwayat percakapan.
     */
    public function index(Request $request): View
    {
        $query = User::where('role', 'anak')
            ->withCount('chatSessions')
            ->with(['chatSessions' => function ($q) {
                $q->with('topic')->withCount('messages')->orderBy('updated_at', 'desc');
            }]);

        // Filter berdasarkan pencarian nama/email siswa
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter siswa berdasarkan topik yang pernah dipelajari
        if ($topicId = $request->input('topic_id')) {
            $query->whereHas('chatSessions', function ($q) use ($topicId) {
                $q->where('topic_id', $topicId);
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        $topics = Topic::all();

        // Agregasi statistik global
        $totalActiveStudents = User::where('role', 'anak')->whereHas('chatSessions')->count();
        $totalSessions = ChatSession::count();
        $totalMessages = ChatMessage::count();

        return view('admin.chat-history.index', compact(
            'users',
            'topics',
            'totalActiveStudents',
            'totalSessions',
            'totalMessages'
        ));
    }

    /**
     * Tampilkan riwayat percakapan lengkap dari siswa tertentu.
     */
    public function show(User $user, Request $request): View
    {
        // Ambil seluruh sesi chat siswa ini beserta topik & pesan
        $sessions = ChatSession::where('user_id', $user->id)
            ->with(['topic', 'messages'])
            ->withCount('messages')
            ->orderBy('is_pinned', 'desc')
            ->orderBy('updated_at', 'desc')
            ->get();

        // Tentukan sesi mana yang sedang aktif dilihat admin
        $activeSessionId = $request->input('session_id');
        $activeSession = null;

        if ($activeSessionId) {
            $activeSession = $sessions->firstWhere('id', $activeSessionId);
        }

        if (!$activeSession) {
            $activeSession = $sessions->first();
        }

        return view('admin.chat-history.show', compact('user', 'sessions', 'activeSession'));
    }

    /**
     * Hapus sesi percakapan tertentu (fitur pembersihan admin).
     */
    public function destroySession(ChatSession $session): RedirectResponse
    {
        $userId = $session->user_id;
        $sessionTitle = $session->title;

        $session->delete();

        return redirect()->route('admin.chat-history.show', $userId)
            ->with('success', "Sesi percakapan '{$sessionTitle}' berhasil dihapus.");
    }
}
