<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Carbon\Carbon;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->get('month', now()->format('Y-m'));
        $date = Carbon::parse($month . '-01');

        $events = Event::whereYear('date', $date->year)
            ->whereMonth('date', $date->month)
            ->orderBy('date')
            ->orderBy('time')
            ->get();

        return view('exercises.events.index', [
            'events' => $events,
            'currentMonth' => $month,
            'monthLabel' => $date->translatedFormat('F Y'),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required|string',
            'reminder' => 'nullable|boolean',
            'description' => 'nullable|string',
        ]);

        Event::create([
            ...$data,
            'reminder' => $request->boolean('reminder'),
        ]);

        return back()->with('success', 'Evento agregado.');
    }

    public function update(Request $request, Event $event)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required|string',
            'reminder' => 'nullable|boolean',
            'description' => 'nullable|string',
        ]);

        $event->update([
            ...$data,
            'reminder' => $request->boolean('reminder'),
        ]);

        return back()->with('success', 'Evento actualizado.');
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return back()->with('success', 'Evento eliminado.');
    }
}
