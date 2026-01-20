<?php

namespace App\Http\Controllers\Admin;

use App\Models\Agenda;
use App\Models\AgendaDocumentation;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AgendaController extends Controller
{
    /**
     * Display a listing of agendas.
     */
    public function index()
    {
        $search = request('search');
        
        $agendas = Agenda::query()
            ->when($search, function ($query, $search) {
                $query->where('title', 'like', "%$search%")
                    ->orWhere('location', 'like', "%$search%");
            })
            ->orderBy('date_start', 'desc')
            ->paginate(10);

        return view('admin.agenda.index', compact('agendas', 'search'));
    }

    /**
     * Show the form for creating a new agenda.
     */
    public function create()
    {
        return view('admin.agenda.create');
    }

    /**
     * Store a newly created agenda in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date_start' => 'required|date_format:Y-m-d\TH:i|after_or_equal:now',
            'date_end' => 'nullable|date_format:Y-m-d\TH:i|after_or_equal:date_start',
            'location' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Auto-publish the agenda
        $validated['is_published'] = true;
        $validated['published_at'] = now();

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('agendas', 'public');
            $validated['image'] = $imagePath;
        }

        Agenda::create($validated);

        return redirect()->route('admin.agenda.index')
            ->with('success', 'Agenda berhasil dibuat dan dipublikasikan!');
    }

    /**
     * Display the specified agenda.
     */
    public function show(Agenda $agenda)
    {
        return view('admin.agenda.show', compact('agenda'));
    }

    /**
     * Show the form for editing the specified agenda.
     */
    public function edit(Agenda $agenda)
    {
        return view('admin.agenda.edit', compact('agenda'));
    }

    /**
     * Update the specified agenda in storage.
     */
    public function update(Request $request, Agenda $agenda)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date_start' => 'required|date_format:Y-m-d\TH:i|after_or_equal:now',
            'date_end' => 'nullable|date_format:Y-m-d\TH:i|after_or_equal:date_start',
            'location' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($agenda->image && \Storage::disk('public')->exists($agenda->image)) {
                \Storage::disk('public')->delete($agenda->image);
            }
            
            $imagePath = $request->file('image')->store('agendas', 'public');
            $validated['image'] = $imagePath;
        }

        $agenda->update($validated);

        return redirect()->route('admin.agenda.index')
            ->with('success', 'Agenda berhasil diperbarui!');
    }

    /**
     * Remove the specified agenda from storage.
     */
    public function destroy(Agenda $agenda)
    {
        // Delete image
        if ($agenda->image && \Storage::disk('public')->exists($agenda->image)) {
            \Storage::disk('public')->delete($agenda->image);
        }

        // Delete documentations
        foreach ($agenda->documentations as $doc) {
            if (\Storage::disk('public')->exists($doc->image_url)) {
                \Storage::disk('public')->delete($doc->image_url);
            }
        }

        $agenda->delete();

        return redirect()->route('admin.agenda.index')
            ->with('success', 'Agenda berhasil dihapus!');
    }

    /**
     * Publish or unpublish agenda
     */
    public function togglePublish(Agenda $agenda)
    {
        $agenda->update([
            'is_published' => !$agenda->is_published,
            'published_at' => !$agenda->is_published ? now() : null,
        ]);

        $message = $agenda->is_published ? 'Agenda berhasil dipublikasikan!' : 'Agenda berhasil disembunyikan!';
        
        return redirect()->route('admin.agenda.index')
            ->with('success', $message);
    }

    /**
     * Upload documentation for agenda
     */
    public function uploadDocumentation(Request $request, Agenda $agenda)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'caption' => 'nullable|string|max:255',
        ]);

        $imagePath = $request->file('image')->store('agenda-documentations', 'public');

        AgendaDocumentation::create([
            'agenda_id' => $agenda->id,
            'image_url' => $imagePath,
            'caption' => $request->caption,
        ]);

        return redirect()->route('admin.agenda.show', $agenda)
            ->with('success', 'Dokumentasi berhasil ditambahkan!');
    }

    /**
     * Delete documentation
     */
    public function deleteDocumentation(AgendaDocumentation $documentation)
    {
        $agendaId = $documentation->agenda_id;
        
        if (\Storage::disk('public')->exists($documentation->image_url)) {
            \Storage::disk('public')->delete($documentation->image_url);
        }

        $documentation->delete();

        return redirect()->route('admin.agenda.show', $agendaId)
            ->with('success', 'Dokumentasi berhasil dihapus!');
    }
}
