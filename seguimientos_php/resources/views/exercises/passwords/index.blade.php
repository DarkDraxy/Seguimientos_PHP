@extends('layouts.app')

@section('title', 'Generador de Contraseñas')
@section('subtitle', 'Genera contraseñas seguras con opciones personalizables')

@section('content')
<div class="grid-2">
    <div class="card">
        <h3>Configuración</h3>
        <form action="{{ route('passwords.generate') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="length">Longitud (4-64)</label>
                <input type="number" id="length" name="length" class="form-control" min="4" max="64" value="{{ $data['length'] ?? 16}}" required>
            </div>
            <div class="form-group">
                <label>Tipos de caracteres</label>
                <div class="checkbox-group">
                    <label>
                        <input type="checkbox" name="lowercase" value="1"
                        {{ (isset($data) && !$data['lowercase']) ? '' : 'checked' }}> Minúsculas
                    </label>

                    <label>
                        <input type="checkbox" name="uppercase" value="1"
                        {{ (isset($data) && !$data['uppercase']) ? '' : 'checked' }}> Mayúsculas
                    </label>

                    <label>
                        <input type="checkbox" name="numbers" value="1"
                        {{ (isset($data) && !$data['numbers']) ? '' : 'checked' }}> Números
                    </label>

                    <label>
                        <input type="checkbox" name="symbols" value="1"
                        {{ (isset($data) && $data['symbols']) ? 'checked' : '' }}> Símbolos
                    </label>
                </div>
                @error('chars')<small style="color:#ef4444">{{ $message }}</small>@enderror
            </div>
            <button type="submit" class="btn btn-primary">Generar contraseña</button>
        </form>
    </div>

    @isset($password)
    <div class="card">
        <h3>Tu contraseña segura</h3>
        <div class="password-display" id="generated-password">{{ $password }}</div>
        <button type="button" class="btn btn-secondary" style="margin-top:1rem;width:100%" onclick="navigator.clipboard.writeText(document.getElementById('generated-password').textContent)">
            Copiar al portapapeles
        </button>
    </div>
    @endif
</div>
@endsection
