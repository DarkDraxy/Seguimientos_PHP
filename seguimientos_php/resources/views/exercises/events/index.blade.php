@extends('layouts.app')

@section('title', 'Calendario de Eventos')
@section('subtitle', 'Agrega, edita y elimina eventos con recordatorios')

@section('content')
<div class="card">
    <form method="GET" style="display:flex;gap:1rem;align-items:end;margin-bottom:1rem">
        <div class="form-group" style="margin:0">
            <label for="month">Mes</label>
            <input type="month" id="month" name="month" class="form-control" value="{{ $currentMonth }}"
                   onchange="this.form.submit()">
        </div>
    </form>
    <h3>Eventos de {{ $monthLabel }}</h3>
</div>

<div class="grid-2">
    <div class="card">
        <h3>Agregar evento</h3>
        <form action="{{ route('events.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="title">Título del evento</label>
                <input type="text" id="title" name="title" class="form-control" required>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="date">Fecha</label>
                    <input type="date" id="date" name="date" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="time">Hora</label>
                    <input type="time" id="time" name="time" class="form-control" required>
                </div>
            </div>
            <div class="form-group">
                <label for="description">Descripción</label>
                <textarea id="description" name="description" class="form-control" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label><input type="checkbox" name="reminder" value="1"> Activar recordatorio</label>
            </div>
            <button type="submit" class="btn btn-primary">Agregar evento</button>
        </form>
    </div>

    <div class="card">
        <h3>Eventos programados</h3>
        @forelse($events as $event)
            <details class="list-item" style="flex-direction:column;align-items:stretch">
                <summary style="cursor:pointer;display:flex;justify-content:space-between;align-items:center">
                    <div>
                        <strong>{{ $event->title }}</strong>
                        @if($event->reminder)
                            <span class="badge badge-warning">🔔 Recordatorio</span>
                        @endif
                        <br><small style="color:#64748b">{{ $event->date->format('Y-m-d') }} · {{ $event->time }}</small>
                    </div>
                </summary>
                <div style="margin-top:1rem">
                    @if($event->description)
                        <p style="font-size:.9rem;margin-bottom:1rem">{{ $event->description }}</p>
                    @endif
                    <form action="{{ route('events.update', $event) }}" method="POST" style="margin-bottom:.5rem">
                        @csrf @method('PATCH')
                        <div class="form-row">
                            <input type="text" name="title" class="form-control" value="{{ $event->title }}" required>
                            <input type="date" name="date" class="form-control" value="{{ $event->date->format('Y-m-d') }}" required>
                            <input type="time" name="time" class="form-control" value="{{ $event->time }}" required>
                        </div>
                        <textarea name="description" class="form-control" rows="2" style="margin-top:.5rem">{{ $event->description ?? '' }}</textarea>
                        <label style="display:block;margin:.5rem 0"><input type="checkbox" name="reminder" value="1" @checked($event->reminder)> Recordatorio</label>
                        <button type="submit" class="btn btn-sm btn-success">Actualizar</button>
                    </form>
                    <form action="{{ route('events.destroy', $event) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Eliminar evento</button>
                    </form>
                </div>
            </details>
        @empty
            <div class="empty-state">No hay eventos este mes</div>
        @endforelse
    </div>
</div>
@endsection
