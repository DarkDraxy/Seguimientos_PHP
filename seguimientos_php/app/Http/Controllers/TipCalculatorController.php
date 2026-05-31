<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TipCalculatorController extends Controller
{
    public function index ()
    {
        return view('exercises.tips.index');
    }

    public function calculate (Request $request)
    {
        $data = request()->validate([
            'amount' => 'required|numeric|min:0',
            'tip_percent' => 'required|numeric|min:0|max:100',
            'people' => 'required|integer|min:1',
        ]);

        $tip = round($data['amount'] * $data['tip_percent'] / 100, 2);
        $total = round($data['amount'] + $tip, 2);
        $perPerson = round($total / $data['people'], 2);

        return view('exercises.tips.index', compact('data','tip', 'total', 'perPerson'));
    }
}
