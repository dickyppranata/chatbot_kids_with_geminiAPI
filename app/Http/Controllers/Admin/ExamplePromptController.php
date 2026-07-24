<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExamplePrompt;
use App\Models\Topic;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExamplePromptController extends Controller
{
    /**
     * Display a listing of the resource.
     * Menampilkan daftar saran pertanyaan (Example Prompt) dengan filter topik & pencarian teks.
     */
    public function index(Request $request): View
    {
        $query = ExamplePrompt::with('topic');

        // Filter berdasarkan pencarian pertanyaan
        if ($search = $request->input('search')) {
            $query->where('question_text', 'like', "%{$search}%");
        }

        // Filter berdasarkan topik
        if ($topicId = $request->input('topic_id')) {
            $query->where('topic_id', $topicId);
        }

        $examplePrompts = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        $topics = Topic::all();

        return view('admin.example-prompts.index', compact('examplePrompts', 'topics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $topics = Topic::all();
        return view('admin.example-prompts.create', compact('topics'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'topic_id'      => ['required', 'exists:topics,id'],
            'question_text' => ['required', 'string', 'max:500'],
        ], [
            'topic_id.required'      => 'Topik pelajaran wajib dipilih.',
            'topic_id.exists'        => 'Topik yang dipilih tidak valid.',
            'question_text.required' => 'Teks contoh pertanyaan wajib diisi.',
            'question_text.max'      => 'Teks pertanyaan maksimal 500 karakter.',
        ]);

        ExamplePrompt::create($validated);

        return redirect()->route('admin.example-prompts.index')->with('success', 'Contoh pertanyaan (Example Prompt) berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $examplePrompt = ExamplePrompt::with('topic')->findOrFail($id);
        return view('admin.example-prompts.show', compact('examplePrompt'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $examplePrompt = ExamplePrompt::findOrFail($id);
        $topics = Topic::all();
        return view('admin.example-prompts.edit', compact('examplePrompt', 'topics'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $examplePrompt = ExamplePrompt::findOrFail($id);

        $validated = $request->validate([
            'topic_id'      => ['required', 'exists:topics,id'],
            'question_text' => ['required', 'string', 'max:500'],
        ], [
            'topic_id.required'      => 'Topik pelajaran wajib dipilih.',
            'topic_id.exists'        => 'Topik yang dipilih tidak valid.',
            'question_text.required' => 'Teks contoh pertanyaan wajib diisi.',
            'question_text.max'      => 'Teks pertanyaan maksimal 500 karakter.',
        ]);

        $examplePrompt->update($validated);

        return redirect()->route('admin.example-prompts.index')->with('success', 'Contoh pertanyaan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $examplePrompt = ExamplePrompt::findOrFail($id);
        $examplePrompt->delete();

        return redirect()->route('admin.example-prompts.index')->with('success', 'Contoh pertanyaan berhasil dihapus.');
    }
}
