@extends('layouts.app')

@section('title', 'Plataforma de Encuestas')
@section('subtitle', 'Crea encuestas, recopila respuestas y analiza resultados')

@section('content')
<div class="grid-2">
    <div class="card">
        <h3>Crear encuesta</h3>
        <form action="{{ route('surveys.store') }}" method="POST" id="survey-form">
            @csrf
            <div class="form-group">
                <label for="title">Título de la encuesta</label>
                <input type="text" id="title" name="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="question">Pregunta</label>
                <input type="text" id="question" name="question" class="form-control" required placeholder="¿Cuál es tu color favorito?">
            </div>
            <div class="form-group">
                <label>Opciones de respuesta</label>
                <div id="options-container">
                    <input type="text" name="options[]" class="form-control" style="margin-bottom:.5rem" placeholder="Opción 1" required>
                    <input type="text" name="options[]" class="form-control" style="margin-bottom:.5rem" placeholder="Opción 2" required>
                </div>
                <button type="button" class="btn btn-sm btn-secondary" onclick="addOption()">+ Agregar opción</button>
            </div>
            <button type="submit" class="btn btn-primary">Crear encuesta</button>
        </form>
    </div>

    <div class="card">
        <h3>Encuestas activas ({{ count($surveys) }})</h3>
        @forelse($surveys as $survey)
            <div class="list-item">
                <div>
                    <strong>{{ $survey->title }}</strong>
                    <br><small style="color:#64748b">{{ $survey->question }}</small>
                    <br><span class="badge badge-primary">{{ $survey->responses }} respuestas</span>
                </div>
                <div class="actions">
                    <a href="{{ route('surveys.show', $survey) }}" class="btn btn-sm btn-primary">Responder</a>
                    <a href="{{ route('surveys.results', $survey) }}" class="btn btn-sm btn-success">Resultados</a>
                    <form action="{{ route('surveys.destroy', $survey) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">×</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="empty-state">Crea tu primera encuesta</div>
        @endforelse
    </div>
</div>
@endsection

@push('scripts')
<script>
function addOption() {
    const container = document.getElementById('options-container');
    const input = document.createElement('input');
    input.type = 'text';
    input.name = 'options[]';
    input.className = 'form-control';
    input.style.marginBottom = '.5rem';
    input.placeholder = 'Nueva opción';
    container.appendChild(input);
}
</script>
@endpush
