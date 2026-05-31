<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PasswordGeneratorController extends Controller
{
    public function index()
    {
        return view('exercises.passwords.index');
    }

    public function generate(Request $request)
    {
        $data = request()->validate([
            'length' => 'required|integer|min:4|max:64',
        ]);

        $data = [
            'length' => (int) $request->input('length'),
            'lowercase' => $request->has('lowercase'),
            'uppercase' => $request->has('uppercase'),
            'numbers' => $request->has('numbers'),
            'symbols' => $request->has('symbols'),
        ];

        $chars = '';

        if ($request->boolean('lowercase')) {
            $chars .= 'abcdefghijklmnopqrstuvwxyz';
        }
        if ($request->boolean('uppercase')) {
            $chars .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }
        if ($request->boolean('numbers')) {
            $chars .= '0123456789';
        }
        if ($request->boolean('symbols')) {
            $chars .= '!@#$%^&*()_+-=[]{}|;:,.<>?';
        }

        if($chars === '')
        {
            return redirect()->route('passwords.index')
                ->withErrors(['chars' => 'Debe seleccionar al menos un tipo de carácter.'])
                ->withInput();
        }

        $password = '';
        $length = (int)$data['length'];
        for ($i = 0; $i < $length; $i++) {
            $password .= $chars[random_int(0, strlen($chars) - 1)];
        }

        return view('exercises.passwords.index', compact('data', 'password'));
    }
}
