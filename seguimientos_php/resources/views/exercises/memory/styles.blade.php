<style>
    .game-controls { display: flex; gap: .75rem; margin-bottom: 1.25rem; flex-wrap: wrap; align-items: center; }
    .game-stats { display: flex; gap: 1.5rem; font-size: .9rem; color: #64748b; }
    .game-stats strong { color: #6366f1; }
    .memory-board {
        display: grid;
        gap: .75rem;
        max-width: 520px;
    }
    .memory-board.easy { grid-template-columns: repeat(4, 1fr); }
    .memory-board.medium { grid-template-columns: repeat(4, 1fr); }
    .memory-board.hard { grid-template-columns: repeat(4, 1fr); }
    .memory-card {
        aspect-ratio: 1; background: var(--accent); border-radius: .75rem; cursor: pointer;
        display: flex; align-items: center; justify-content: center; font-size: 2rem;
        transition: transform .2s, background .2s; user-select: none;
        box-shadow: 0 4px 6px rgba(99,102,241,.3);
    }
    .memory-card.flipped, .memory-card.matched { background: #fff; border: 2px solid var(--accent); }
    .memory-card.matched { background: #dcfce7; border-color: var(--success); cursor: default; opacity: .8; }
    .memory-card .back { display: block; }
    .memory-card .front { display: none; }
    .memory-card.flipped .back, .memory-card.matched .back { display: none; }
    .memory-card.flipped .front, .memory-card.matched .front { display: block; }
    .level-btn.active { background: var(--accent); color: #fff; }
</style>
