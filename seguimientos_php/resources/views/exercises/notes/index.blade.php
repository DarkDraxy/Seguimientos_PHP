@extends('layouts.app')

@section('title', 'Gestor de Notas')
@section('subtitle', 'Escribe, organiza y busca tus notas por categoría')

@section('content')
<div class="card">
    <h3>Buscar y filtrar</h3>
    <form method="GET" class="form-row">
        <div class="form-group">
            <input type="text" name="search" class="form-control" placeholder="Buscar notas..." value="{{ $search }}">
        </div>
        <div class="form-group">
            <select name="category" class="form-control">
                <option value="">Todas las categorías</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" @selected($selectedCategory == $cat)>{{ $cat }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group" style="display:flex;align-items:end">
            <button type="submit" class="btn btn-primary">Buscar</button>
        </div>
    </form>
</div>

<div class="grid-2">
    <div class="card">
        <h3>Nueva nota</h3>
        <form action="{{ route('notes.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="title">Título</label>
                <input type="text" id="title" name="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="category">Categoría</label>
                <select id="category" name="category" class="form-control">
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}">{{ $cat }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="content">Contenido</label>
                <textarea id="content" name="content" class="form-control" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Guardar nota</button>
        </form>
    </div>

    <div class="card">
        <h3>Notas ({{ count($notes) }})</h3>
        @forelse($notes as $note)
            <div class="list-item" style="flex-direction:column;align-items:stretch">
                <div style="display:flex;justify-content:space-between;align-items:start">
                    <div>
                        <strong>{{ $note->title }}</strong>
                        <span class="badge badge-primary">{{ $note->category }}</span>
                        <br><small style="color:#64748b">{{ $note->created_at->format('d/m/Y H:i') }}</small>
                    </div>
                    <form action="{{ route('notes.destroy', $note) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                    </form>
                </div>
                <p style="margin-top:.75rem;font-size:.9rem;color:#475569">{{ $note->content }}</p>
            </div>
        @empty
            <div class="empty-state">No se encontraron notas</div>
        @endforelse
    </div>
</div>
@endsection
