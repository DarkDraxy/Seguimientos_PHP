@extends('layouts.app')

@section('title', 'Resultados: '.$survey->title)
@section('subtitle', 'Informe visual de respuestas')

@section('content')
<div class="card">
    <h3>{{ $survey->question }}</h3>
    <p style="color:#64748b;margin-bottom:1.5rem">Total de respuestas: <strong>{{ $survey->responses }}</strong></p>

    @foreach($survey->options as $option)
        @php $percent = $survey->responses > 0 ? round(($option->votes / $survey->responses) * 100) : 0; @endphp
        <div class="chart-bar">
            <div class="bar-label">
                <span>{{ $option->text }}</span>
                <span>{{ $option->votes }} votos ({{ $percent }}%)</span>
            </div>
            <div class="bar-track">
                <div class="bar-fill" style="width:{{ $percent }}%"></div>
            </div>
        </div>
    @endforeach

    <div class="actions" style="margin-top:1.5rem">
        <a href="{{ route('surveys.show', $survey) }}" class="btn btn-primary">Responder de nuevo</a>
        <a href="{{ route('surveys.index') }}" class="btn btn-secondary">Volver al listado</a>
    </div>
</div>
@endsection
