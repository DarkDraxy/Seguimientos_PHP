@extends('layouts.app')

@section('title', 'Calculadora de Propinas')
@section('subtitle', 'Calcula la propina según el monto y porcentaje seleccionado')

@section('content')
<div class="grid-2">
    <div class="card">
        <h3>Datos de la cuenta</h3>
        <form action="{{ route('tips.calculate') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="amount">Monto total ($)</label>
                <input type="number" step="0.01" id="amount" name="amount" class="form-control" value="{{ old('amount', $data['amount'] ?? '') }}" required>
            </div>
            <div class="form-group">
                <label for="tip_percent">Porcentaje de propina (%)</label>
                <select id="tip_percent" name="tip_percent" class="form-control">
                    @foreach([5, 10, 15, 20, 25, 30, 35, 40] as $pct)
                        <option value="{{ $pct }}" @selected(old('tip_percent', $data['tip_percent'] ?? 15) == $pct)>{{ $pct }}%</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="people">Número de personas</label>
                <input type="number" id="people" name="people" class="form-control" min="1" value="{{ old('people', $data['people'] ?? 1) }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Calcular propina</button>
        </form>
    </div>

    @isset($total)
    <div class="card">
        <h3>Resultado</h3>
        <div class="result-box">
            <p style="color:#64748b;margin-bottom:.5rem">Propina ({{ $data['tip_percent'] }}%)</p>
            <div class="amount">${{ number_format($tip, 2) }}</div>
            <hr style="margin:1rem 0;border:none;border-top:1px solid #bbf7d0">
            <p><strong>Total con propina:</strong> ${{ number_format($total, 2) }}</p>
            <p><strong>Por persona:</strong> ${{ number_format($perPerson, 2) }}</p>
        </div>
    </div>
    @endif
</div>
@endsection
