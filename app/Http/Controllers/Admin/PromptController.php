<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prompt;
use App\Models\Topic;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PromptController extends Controller
{
    /**
     * Display a listing of the resource.
     * Menampilkan daftar Few-Shot System Prompt dengan filter topik & pencarian teks.
     */
    public function index(Request $request): View
    {
        $query = Prompt::with('topic');

        // Filter berdasarkan pencarian teks prompt
        if ($search = $request->input('search')) {
            $query->where('prompt_text', 'like', "%{$search}%");
        }

        // Filter berdasarkan topik
        if ($topicId = $request->input('topic_id')) {
            $query->where('topic_id', $topicId);
        }

        $prompts = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        $topics = Topic::all();

        return view('admin.prompts.index', compact('prompts', 'topics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $topics = Topic::all();
        return view('admin.prompts.create', compact('topics'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'topic_id'    => ['required', 'exists:topics,id'],
            'prompt_text' => ['required', 'string'],
        ], [
            'topic_id.required'    => 'Topik pelajaran wajib dipilih.',
            'topic_id.exists'      => 'Topik yang dipilih tidak ditemukan.',
            'prompt_text.required' => 'Teks Few-Shot System Prompt wajib diisi.',
        ]);

        Prompt::create($validated);

        return redirect()->route('admin.prompts.index')->with('success', 'Few-Shot System Prompt berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $prompt = Prompt::with('topic')->findOrFail($id);
        return view('admin.prompts.show', compact('prompt'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $prompt = Prompt::findOrFail($id);
        $topics = Topic::all();
        return view('admin.prompts.edit', compact('prompt', 'topics'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $prompt = Prompt::findOrFail($id);

        $validated = $request->validate([
            'topic_id'    => ['required', 'exists:topics,id'],
            'prompt_text' => ['required', 'string'],
        ], [
            'topic_id.required'    => 'Topik pelajaran wajib dipilih.',
            'topic_id.exists'      => 'Topik yang dipilih tidak ditemukan.',
            'prompt_text.required' => 'Teks Few-Shot System Prompt wajib diisi.',
        ]);

        $prompt->update($validated);

        return redirect()->route('admin.prompts.index')->with('success', 'Few-Shot System Prompt berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $prompt = Prompt::findOrFail($id);

        // Jika prompt memiliki percakapan siswa, cegah hapus agar riwayat belajar siswa aman
        if ($prompt->chatSessions()->count() > 0) {
            return back()->with('error', "Prompt ini tidak dapat dihapus karena sudah memiliki riwayat percakapan dengan siswa.");
        }

        $prompt->delete();

        return redirect()->route('admin.prompts.index')->with('success', 'Few-Shot System Prompt berhasil dihapus.');
    }
}
