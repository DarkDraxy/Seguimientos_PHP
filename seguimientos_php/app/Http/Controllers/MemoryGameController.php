<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MemoryGameController extends Controller
{
    public function index(Request $request)
    {
        $level = $request->get('level', 'easy');
        $pairs = match ($level) {
            'hard' => 8,
            'medium' => 6,
            default => 4,
        };

        $symbols = ['🍎', '🍊', '🍋', '🍇', '🍓', '🥝', '🍑', '🍒', '🥑', '🫐', '🍌', '🥭'];
        $cards = array_slice($symbols, 0, $pairs);
        $deck = array_merge($cards, $cards);
        shuffle($deck);

        return view('exercises.memory.index', [
            'deck' => $deck,
            'level' => $level,
            'pairs' => $pairs,
        ]);
    }
}
