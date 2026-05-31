@extends('layouts.app')

@section('title', 'Lista de Tareas')
@section('subtitle', 'Agrega, elimina y marca tareas como completadas')

@section('content')
<div class="card">
    <h3>Nueva tarea</h3>
    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="title">Descripción de la tarea</label>
            <input type="text" id="title" name="title" class="form-control" placeholder="Ej: Estudiar Laravel MVC" required value="{{ old('title') }}">
            @error('title')<small style="color:#ef4444">{{ $message }}</small>@enderror
        </div>
        <button type="submit" class="btn btn-primary">Agregar tarea</button>
    </form>
</div>

<div class="card">
    <h3>Mis tareas ({{ count($tasks) }})</h3>
    @forelse($tasks as $task)
        <div class="list-item {{ $task->completed ? 'completed' : '' }}">
            <span>{{ $task->title }}</span>
            <div class="actions">
                <form action="{{ route('tasks.toggle', $task) }}" method="POST">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn btn-sm {{ $task->completed ? 'btn-secondary' : 'btn-success' }}">
                        {{ $task->completed ? 'Desmarcar' : 'Completar' }}
                    </button>
                </form>
                <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
    @empty
        <div class="empty-state">No hay tareas. ¡Agrega la primera!</div>
    @endforelse
</div>
@endsection
