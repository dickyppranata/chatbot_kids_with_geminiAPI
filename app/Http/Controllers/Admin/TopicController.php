<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Topic;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     * Menampilkan daftar topik dengan pencarian & jumlah prompt/sesi chat terkait.
     */
    public function index(Request $request): View
    {
        $query = Topic::withCount(['prompts', 'examplePrompts', 'chatSessions']);

        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        $topics = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('admin.topics.index', compact('topics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.topics.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'slug'        => ['nullable', 'string', 'max:255', 'unique:topics,slug'],
            'description' => ['nullable', 'string'],
        ], [
            'name.required' => 'Nama topik wajib diisi.',
            'slug.unique'   => 'Slug ini sudah digunakan oleh topik lain.',
        ]);

        $slug = !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['name']);

        Topic::create([
            'name'        => $validated['name'],
            'slug'        => $slug,
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('admin.topics.index')->with('success', 'Topik pelajaran baru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $topic = Topic::with(['prompts', 'examplePrompts'])->withCount('chatSessions')->findOrFail($id);

        return view('admin.topics.show', compact('topic'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $topic = Topic::findOrFail($id);

        return view('admin.topics.edit', compact('topic'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $topic = Topic::findOrFail($id);

        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'slug'        => ['nullable', 'string', 'max:255', 'unique:topics,slug,' . $topic->id],
            'description' => ['nullable', 'string'],
        ], [
            'name.required' => 'Nama topik wajib diisi.',
            'slug.unique'   => 'Slug ini sudah digunakan oleh topik lain.',
        ]);

        $slug = !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['name']);

        $topic->update([
            'name'        => $validated['name'],
            'slug'        => $slug,
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('admin.topics.index')->with('success', 'Topik pelajaran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $topic = Topic::findOrFail($id);

        // Jika topik memiliki percakapan siswa, cegah hapus agar riwayat belajar siswa aman
        if ($topic->chatSessions()->count() > 0) {
            return back()->with('error', "Topik '{$topic->name}' tidak dapat dihapus karena sudah memiliki riwayat percakapan dengan siswa.");
        }

        $topic->delete();

        return redirect()->route('admin.topics.index')->with('success', 'Topik pelajaran berhasil dihapus.');
    }
}
