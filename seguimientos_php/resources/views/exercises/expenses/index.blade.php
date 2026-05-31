@extends('layouts.app')

@section('title', 'Gestor de Gastos')
@section('subtitle', 'Registra gastos diarios y consulta el resumen mensual')

@section('content')
<div class="summary-grid" style="margin-bottom:1.25rem">
    <div class="summary-card">
        <div class="value">${{ number_format($monthlyTotal, 2) }}</div>
        <div class="label">Total {{ $currentMonth }}</div>
    </div>
    @foreach($byCategory as $cat => $amount)
    <div class="summary-card">
        <div class="value">${{ number_format($amount, 2) }}</div>
        <div class="label">{{ $cat }}</div>
    </div>
    @endforeach
</div>

<div class="grid-2">
    <div class="card">
        <h3>Registrar gasto</h3>
        <form action="{{ route('expenses.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="description">Descripción</label>
                <input type="text" id="description" name="description" class="form-control" required value="{{ old('description') }}">
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="amount">Monto ($)</label>
                    <input type="number" step="0.01" id="amount" name="amount" class="form-control" required value="{{ old('amount') }}">
                </div>
                <div class="form-group">
                    <label for="date">Fecha</label>
                    <input type="date" id="date" name="date" class="form-control" required value="{{ old('date', now()->format('Y-m-d')) }}">
                </div>
            </div>
            <div class="form-group">
                <label for="category">Categoría</label>
                <select id="category" name="category" class="form-control">
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}">{{ $cat }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Registrar</button>
        </form>
    </div>

    <div class="card">
        <h3>Historial de gastos</h3>
        @forelse($expenses as $expense)
            <div class="list-item">
                <div>
                    <strong>{{ $expense->description }}</strong>
                    <br><small style="color:#64748b">{{ $expense->date->format('Y-m-d') }} · <span class="badge badge-primary">{{ $expense->category }}</span></small>
                </div>
                <div class="actions">
                    <span style="font-weight:700;color:#6366f1">${{ number_format($expense->amount, 2) }}</span>
                    <form action="{{ route('expenses.destroy', $expense) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">×</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="empty-state">Sin gastos registrados</div>
        @endforelse
    </div>
</div>
@endsection
