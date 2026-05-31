@extends('layouts.app')

@section('title', $survey->title)
@section('subtitle', 'Responde la encuesta')

@section('content')
<div class="card" style="max-width:600px">
    <h3>{{ $survey->question }}</h3>
    <form action="{{ route('surveys.vote', $survey) }}" method="POST">
        @csrf
        @foreach($survey->options as $index => $option)
            <label class="list-item" style="cursor:pointer">
                <span>{{ $option->text }}</span>
                <input type="radio" name="option_index" value="{{ $index }}" required>
            </label>
        @endforeach
        <button type="submit" class="btn btn-primary" style="margin-top:1rem">Enviar respuesta</button>
        <a href="{{ route('surveys.index') }}" class="btn btn-secondary" style="margin-top:1rem">Volver</a>
    </form>
</div>
@endsection
