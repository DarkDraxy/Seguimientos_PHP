@extends('layouts.app')

@section('title', 'Sistema de Reservas')
@section('subtitle', 'Reserva citas en línea con disponibilidad en tiempo real')

@section('content')
<div class="grid-2">
    <div class="card">
        <h3>Nueva reserva</h3>
        <form action="{{ route('reservations.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Nombre completo</label>
                <input type="text" id="name" name="name" class="form-control" required value="{{ old('name') }}">
            </div>
                <div class="form-group">
                    <label for="service">Servicio</label>
                    <select id="service" name="service" class="form-control" onchange="window.location='?date='+document.getElementById('date').value+'&service='+this.value">
                        @foreach($services as $key => $label)
                            <option value="{{ $key }}" @selected(request('service') == $key)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="date">Fecha</label>
                          <input type="date" id="date" name="date" class="form-control" required
                              value="{{ old('date', $selectedDate) }}" min="{{ now()->format('Y-m-d') }}"
                              onchange="window.location='?date='+this.value+'&service='+document.getElementById('service').value">
                </div>
                <div class="form-group">
                    <label for="slot">Horario disponible</label>
                    <select id="slot" name="slot" class="form-control" required>
                        @foreach($slots as $slot)
                            <option value="{{ $slot }}" @disabled(in_array($slot, $bookedSlots)) @selected(old('slot') == $slot)>
                                {{ $slot }} {{ in_array($slot, $bookedSlots) ? '(Ocupado)' : '' }}
                            </option>
                        @endforeach
                    </select>
                    @error('slot')<small style="color:#ef4444">{{ $message }}</small>@enderror
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Confirmar reserva</button>
        </form>
    </div>

    <div class="card">
        <h3>Reservas confirmadas</h3>
        @forelse($reservations as $res)
            <div class="list-item">
                <div>
                    <strong>{{ $res->name }}</strong>
                    <br><small style="color:#64748b">{{ $res->service_name }} · {{ $res->date->format('Y-m-d') }} {{ $res->slot }}</small>
                    <br><span class="badge badge-success">Confirmada</span>
                </div>
                <form action="{{ route('reservations.destroy', $res) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Cancelar</button>
                </form>
            </div>
        @empty
            <div class="empty-state">No hay reservas activas</div>
        @endforelse
    </div>
</div>
@endsection
