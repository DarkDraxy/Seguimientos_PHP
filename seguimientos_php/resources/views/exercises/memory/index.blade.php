@extends('layouts.app')

@section('title', 'Juego de Memoria')
@section('subtitle', 'Empareja cartas con diferentes niveles de dificultad')

@push('styles')
    @include('exercises.memory.styles')
@endpush

@section('content')
<div class="card">
    <div class="game-controls">
        <span>Dificultad:</span>
        @foreach(['easy' => 'Fácil (4 pares)', 'medium' => 'Medio (6 pares)', 'hard' => 'Difícil (8 pares)'] as $key => $label)
            <a href="?level={{ $key }}" class="btn btn-sm btn-secondary level-btn {{ $level === $key ? 'active' : '' }}">{{ $label }}</a>
        @endforeach
        <a href="?level={{ $level }}" class="btn btn-sm btn-primary">Reiniciar</a>
    </div>
    <div class="game-stats">
        <span>Movimientos: <strong id="moves">0</strong></span>
        <span>Pares encontrados: <strong id="pairs">0</strong> / {{ $pairs }}</span>
        <span>Tiempo: <strong id="timer">0:00</strong></span>
    </div>
</div>

<div class="card">
    <div class="memory-board {{ $level }}" id="board">
        @foreach($deck as $index => $symbol)
            <div class="memory-card" data-symbol="{{ $symbol }}" data-index="{{ $index }}">
                <span class="back">?</span>
                <span class="front">{{ $symbol }}</span>
            </div>
        @endforeach
    </div>
    <div id="win-message" class="alert alert-success" style="display:none;margin-top:1rem"></div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const cards = document.querySelectorAll('.memory-card');
    let flipped = [], matched = 0, moves = 0, lock = false;
    const totalPairs = {{ $pairs }};
    let seconds = 0, timerInterval;

    function startTimer() {
        if (timerInterval) return;
        timerInterval = setInterval(() => {
            seconds++;
            const m = Math.floor(seconds / 60), s = seconds % 60;
            document.getElementById('timer').textContent = `${m}:${s.toString().padStart(2,'0')}`;
        }, 1000);
    }

    cards.forEach(card => {
        card.addEventListener('click', () => {
            if (lock || card.classList.contains('flipped') || card.classList.contains('matched')) return;
            startTimer();
            card.classList.add('flipped');
            flipped.push(card);

            if (flipped.length === 2) {
                moves++;
                document.getElementById('moves').textContent = moves;
                lock = true;

                if (flipped[0].dataset.symbol === flipped[1].dataset.symbol) {
                    flipped.forEach(c => c.classList.add('matched'));
                    matched++;
                    document.getElementById('pairs').textContent = matched;
                    flipped = []; lock = false;

                    if (matched === totalPairs) {
                        clearInterval(timerInterval);
                        const msg = document.getElementById('win-message');
                        msg.style.display = 'block';
                        msg.textContent = `¡Ganaste en ${moves} movimientos y ${document.getElementById('timer').textContent}!`;
                    }
                } else {
                    setTimeout(() => {
                        flipped.forEach(c => c.classList.remove('flipped'));
                        flipped = []; lock = false;
                    }, 800);
                }
            }
        });
    });
});
</script>
@endpush
