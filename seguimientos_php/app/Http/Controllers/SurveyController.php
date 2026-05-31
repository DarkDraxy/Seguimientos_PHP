<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Survey;
use Illuminate\Support\Facades\DB;

class SurveyController extends Controller
{
    public function index()
    {
        return view('exercises.surveys.index', [
            'surveys' => Survey::latest()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'question' => 'required|string|max:500',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string|max:255',
        ]);

        DB::transaction(function () use ($data) {
            $survey = Survey::create([
                'title' => $data['title'],
                'question' => $data['question'],
                'responses' => 0,
            ]);

            foreach (collect($data['options'])->filter()->values() as $option) {
                $survey->options()->create(['text' => $option, 'votes' => 0]);
            }
        });

        return back()->with('success', 'Encuesta creada.');
    }

    public function show(Survey $survey)
    {
        $survey->load('options');

        return view('exercises.surveys.show', compact('survey'));
    }

    public function vote(Request $request, Survey $survey)
    {
        $request->validate(['option_index' => 'required|integer|min:0']);

        $options = $survey->options()->orderBy('id')->get();
        $option = $options->get((int) $request->option_index);

        if (! $option) {
            abort(404);
        }

        DB::transaction(function () use ($survey, $option) {
            $option->increment('votes');
            $survey->increment('responses');
        });

        return redirect()->route('surveys.results', $survey)->with('success', '¡Gracias por responder!');
    }

    public function results(Survey $survey)
    {
        $survey->load('options');
        $total = max($survey->responses, 1);

        return view('exercises.surveys.results', compact('survey', 'total'));
    }

    public function destroy(Survey $survey)
    {
        $survey->delete();

        return back()->with('success', 'Encuesta eliminada.');
    }
}
