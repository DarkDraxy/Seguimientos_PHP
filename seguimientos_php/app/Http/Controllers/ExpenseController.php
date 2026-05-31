<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Expense;

class ExpenseController extends Controller
{
    private const CATEGORIES = ['Alimentación', 'Transporte', 'Entretenimiento', 'Salud', 'Otros'];

    public function index ()
    {
        $monthly = Expense::whereYear('date', now()->year)
            ->whereMonth('date', now()->month)
            ->get();

        return view('exercises.expenses.index',[
            'expenses' => Expense::latest('date')->get(),
            'categories' => self::CATEGORIES,
            'byCategory' => $monthly->groupBy('category')->map->sum('amount'),
            'monthlyTotal' => $monthly->sum('amount'),
            'currentMonth' => now()->translatedFormat('F Y'),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'category' => 'required|string',
            'date' => 'required|date',
        ]);

        Expense::create($data);

        return back()->with('success', 'Gasto registrado exitosamente.');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();

        return back()->with('success', 'Gasto eliminado exitosamente.');
    }
}
