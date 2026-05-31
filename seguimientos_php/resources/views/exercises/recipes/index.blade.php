@extends('layouts.app')

@section('title', 'Plataforma de Recetas')
@section('subtitle', 'Busca, guarda y comparte recetas de cocina')

@section('content')
<div class="card">
    <h3>Buscar recetas</h3>
    <form method="GET" class="form-row">
        <div class="form-group">
            <input type="text" name="search" class="form-control" placeholder="Nombre de receta..." value="{{ $search }}">
        </div>
        <div class="form-group">
            <select name="type" class="form-control">
                <option value="">Todos los tipos</option>
                @foreach($types as $t)
                    <option value="{{ $t }}" @selected($selectedType == $t)>{{ $t }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <input type="text" name="ingredient" class="form-control" placeholder="Filtrar por ingrediente..." value="{{ $ingredient }}">
        </div>
        <div class="form-group" style="display:flex;align-items:end">
            <button type="submit" class="btn btn-primary">Filtrar</button>
        </div>
    </form>
</div>

<div class="grid-2">
    <div class="card">
        <h3>Compartir receta</h3>
        <form action="{{ route('recipes.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="type">Tipo de comida</label>
                <select id="type" name="type" class="form-control">
                    @foreach($types as $t)
                        <option value="{{ $t }}">{{ $t }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="ingredients">Ingredientes (separados por coma)</label>
                <textarea id="ingredients" name="ingredients" class="form-control" rows="3" required placeholder="Harina, huevos, leche..."></textarea>
            </div>
            <div class="form-group">
                <label for="instructions">Instrucciones</label>
                <textarea id="instructions" name="instructions" class="form-control" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Guardar receta</button>
        </form>
    </div>

    <div class="card">
        <h3>Recetas ({{ count($recipes) }})</h3>
        @forelse($recipes as $recipe)
            <div class="list-item" style="flex-direction:column;align-items:stretch">
                <div style="display:flex;justify-content:space-between">
                    <div>
                        <strong>{{ $recipe->name }}</strong>
                        <span class="badge badge-primary">{{ $recipe->type }}</span>
                        <br><small style="color:#64748b">Por {{ $recipe->author }}</small>
                    </div>
                    <form action="{{ route('recipes.destroy', $recipe) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">×</button>
                    </form>
                </div>
                <p style="margin-top:.5rem;font-size:.85rem"><strong>Ingredientes:</strong> {{ $recipe->ingredients }}</p>
                <p style="font-size:.85rem;color:#475569">{{ $recipe->instructions }}</p>
            </div>
        @empty
            <div class="empty-state">No hay recetas. ¡Comparte la primera!</div>
        @endforelse
    </div>
</div>
@endsection
