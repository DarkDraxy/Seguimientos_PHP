<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;

class RecipeController extends Controller
{
    private const TYPES = ['Desayuno', 'Almuerzo', 'Cena', 'Postre', 'Snack'];

    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $type = $request->get('type', '');
        $ingredient = $request->get('ingredient', '');

        $recipes = Recipe::query()
            ->when($search, fn ($q) => $q->where('name', 'like', "%{$search}%"))
            ->when($type, fn ($q) => $q->where('type', $type))
            ->when($ingredient, fn ($q) => $q->where('ingredients', 'like', "%{$ingredient}%"))
            ->latest()
            ->get();

        return view('exercises.recipes.index', [
            'recipes' => $recipes,
            'types' => self::TYPES,
            'search' => $search,
            'selectedType' => $type,
            'ingredient' => $ingredient,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'ingredients' => 'required|string',
            'instructions' => 'required|string',
        ]);

        Recipe::create([...$data, 'author' => 'Usuario']);

        return back()->with('success', 'Receta guardada y compartida.');
    }

    public function destroy(Recipe $recipe)
    {
        $recipe->delete();

        return back()->with('success', 'Receta eliminada.');
    }
}
