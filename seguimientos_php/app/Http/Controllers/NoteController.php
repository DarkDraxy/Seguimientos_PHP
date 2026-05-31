<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;

class NoteController extends Controller
{
    private const categories = ['Personal', 'Trabajo', 'Estudio', 'Otros'];

    public function index(Request $request)
     {
        $search = $request->get('search' , '');
        $category = $request->get('category');

        $notes = Note::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
                });
            })
            ->when($category, function ($query) use ($category) {
                $query->where('category', $category);
            })
            ->latest()
            ->get();

            return view('exercises.notes.index', [
                'notes' => $notes,
                'categories' => self::categories,
                'search' => $search,
                'selectedCategory' => $category,
            ]);
     }

     public function store(Request $request)
     {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|string',
        ]);

        Note::create($data);

        return back()->with('success', 'Nota creada exitosamente.');
     }

     public function destroy(Note $note)
     {
        $note->delete();

        return back()->with('success', 'Nota eliminada exitosamente.');
     }

}

