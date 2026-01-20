<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Routing\Controller;

class PublicAgendaController extends Controller
{
    /**
     * Display a listing of published agendas.
     */
    public function index()
    {
        $agendas = Agenda::published()
            ->orderByRaw("CASE 
                WHEN status = 'ongoing' THEN 1
                WHEN status = 'upcoming' THEN 2
                WHEN status = 'done' THEN 3
                ELSE 4
            END")
            ->orderBy('date_start', 'desc')
            ->paginate(12);

        return view('public.agenda.index', compact('agendas'));
    }

    /**
     * Display the specified agenda.
     */
    public function show(Agenda $agenda)
    {
        // Only show published agendas
        if (!$agenda->is_published) {
            abort(404);
        }

        $documentations = $agenda->documentations()->get();

        return view('public.agenda.show', compact('agenda', 'documentations'));
    }
}
