<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminAgendaController extends Controller
{
    public function index(Request $request): View
    {
        $query = Agenda::withCount(['comments', 'likes']);

        if ($request->filled('q')) {
            $keyword = $request->q;
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', '%' . $keyword . '%')
                    ->orWhere('content', 'like', '%' . $keyword . '%');
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $agendas = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $categories = Agenda::CATEGORIES;

        return view('admin.agenda.index', compact('agendas', 'categories'));
    }

    public function create(): View
    {
        $categories = Agenda::CATEGORIES;

        return view('admin.agenda.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:' . implode(',', Agenda::CATEGORIES),
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('agenda', 'public');
        }

        Agenda::create($validated);

        return redirect()->route('admin.agenda.index')
            ->with('success', 'Postingan agenda berhasil ditambahkan.');
    }

    public function edit($id): View
    {
        $agenda = Agenda::findOrFail($id);
        $categories = Agenda::CATEGORIES;

        return view('admin.agenda.edit', compact('agenda', 'categories'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $agenda = Agenda::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:' . implode(',', Agenda::CATEGORIES),
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        if ($request->hasFile('image')) {
            if ($agenda->image_path) {
                Storage::disk('public')->delete($agenda->image_path);
            }

            $validated['image_path'] = $request->file('image')->store('agenda', 'public');
        }

        $agenda->update($validated);

        return redirect()->route('admin.agenda.index')
            ->with('success', 'Postingan agenda berhasil diperbarui.');
    }

    public function destroy($id): RedirectResponse
    {
        $agenda = Agenda::findOrFail($id);

        if ($agenda->image_path) {
            Storage::disk('public')->delete($agenda->image_path);
        }

        $agenda->delete();

        return redirect()->route('admin.agenda.index')
            ->with('success', 'Postingan agenda berhasil dihapus.');
    }
}
