<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Ejercicios MVC') — Laravel</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --sidebar-w: 280px;
            --bg: #0f172a;
            --sidebar: #1e293b;
            --accent: #6366f1;
            --accent-hover: #818cf8;
            --text: #f1f5f9;
            --muted: #94a3b8;
            --card: #ffffff;
            --border: #e2e8f0;
            --success: #22c55e;
            --danger: #ef4444;
            --warning: #f59e0b;
        }
        body { font-family: 'Segoe UI', system-ui, sans-serif; background: #f8fafc; color: #1e293b; min-height: 100vh; display: flex; }
        .sidebar {
            width: var(--sidebar-w); min-height: 100vh; background: var(--sidebar);
            color: var(--text); display: flex; flex-direction: column; position: fixed; left: 0; top: 0; z-index: 100;
            border-right: 1px solid rgba(255,255,255,.08);
        }
        .sidebar-header { padding: 1.5rem 1.25rem; border-bottom: 1px solid rgba(255,255,255,.08); }
        .sidebar-header h1 { font-size: 1.1rem; font-weight: 700; }
        .sidebar-header p { font-size: .75rem; color: var(--muted); margin-top: .25rem; }
        .sidebar-nav { flex: 1; overflow-y: auto; padding: .75rem; }
        .sidebar-nav a {
            display: flex; align-items: center; gap: .75rem; padding: .65rem .85rem;
            border-radius: .5rem; color: var(--muted); text-decoration: none; font-size: .875rem;
            margin-bottom: .25rem; transition: all .15s;
        }
        .sidebar-nav a:hover { background: rgba(255,255,255,.06); color: var(--text); }
        .sidebar-nav a.active { background: var(--accent); color: #fff; font-weight: 600; }
        .sidebar-nav .icon { font-size: 1.1rem; width: 1.5rem; text-align: center; }
        .sidebar-footer { padding: 1rem 1.25rem; border-top: 1px solid rgba(255,255,255,.08); font-size: .7rem; color: var(--muted); }
        .main { margin-left: var(--sidebar-w); flex: 1; min-height: 100vh; }
        .main-header { background: var(--card); border-bottom: 1px solid var(--border); padding: 1.25rem 2rem; }
        .main-header h2 { font-size: 1.5rem; font-weight: 700; }
        .main-header p { color: #64748b; font-size: .9rem; margin-top: .25rem; }
        .main-content { padding: 2rem; max-width: 960px; }
        .card { background: var(--card); border: 1px solid var(--border); border-radius: .75rem; padding: 1.5rem; margin-bottom: 1.25rem; box-shadow: 0 1px 3px rgba(0,0,0,.05); }
        .card h3 { font-size: 1rem; font-weight: 600; margin-bottom: 1rem; color: #334155; }
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; font-size: .875rem; font-weight: 500; margin-bottom: .35rem; color: #475569; }
        .form-control {
            width: 100%; padding: .55rem .75rem; border: 1px solid var(--border); border-radius: .5rem;
            font-size: .9rem; transition: border-color .15s;
        }
        .form-control:focus { outline: none; border-color: var(--accent); box-shadow: 0 0 0 3px rgba(99,102,241,.15); }
        .form-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem; }
        .btn {
            display: inline-flex; align-items: center; gap: .4rem; padding: .55rem 1.1rem;
            border: none; border-radius: .5rem; font-size: .875rem; font-weight: 500; cursor: pointer; transition: all .15s;
        }
        .btn-primary { background: var(--accent); color: #fff; }
        .btn-primary:hover { background: var(--accent-hover); }
        .btn-success { background: var(--success); color: #fff; }
        .btn-success:hover { background: #16a34a; }
        .btn-danger { background: var(--danger); color: #fff; }
        .btn-danger:hover { background: #dc2626; }
        .btn-secondary { background: #e2e8f0; color: #475569; }
        .btn-secondary:hover { background: #cbd5e1; }
        .btn-sm { padding: .35rem .75rem; font-size: .8rem; }
        .alert { padding: .75rem 1rem; border-radius: .5rem; margin-bottom: 1rem; font-size: .875rem; }
        .alert-success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
        .alert-info { background: #dbeafe; color: #1e40af; border: 1px solid #bfdbfe; }
        .list { list-style: none; }
        .list-item {
            display: flex; align-items: center; justify-content: space-between; gap: 1rem;
            padding: .75rem 1rem; border: 1px solid var(--border); border-radius: .5rem; margin-bottom: .5rem;
        }
        .list-item.completed { opacity: .6; text-decoration: line-through; }
        .badge { display: inline-block; padding: .2rem .6rem; border-radius: 999px; font-size: .75rem; font-weight: 600; }
        .badge-primary { background: #ede9fe; color: #5b21b6; }
        .badge-success { background: #dcfce7; color: #166534; }
        .badge-warning { background: #fef3c7; color: #92400e; }
        .result-box { background: #f0fdf4; border: 2px solid #bbf7d0; border-radius: .75rem; padding: 1.25rem; text-align: center; }
        .result-box .amount { font-size: 2rem; font-weight: 700; color: #166534; }
        .password-display { font-family: 'Consolas', monospace; font-size: 1.25rem; background: #1e293b; color: #a5f3fc; padding: 1rem; border-radius: .5rem; word-break: break-all; text-align: center; }
        .checkbox-group { display: flex; flex-wrap: wrap; gap: 1rem; }
        .checkbox-group label { display: flex; align-items: center; gap: .4rem; font-size: .875rem; cursor: pointer; }
        .summary-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 1rem; }
        .summary-card { background: #f8fafc; border: 1px solid var(--border); border-radius: .5rem; padding: 1rem; text-align: center; }
        .summary-card .value { font-size: 1.5rem; font-weight: 700; color: var(--accent); }
        .summary-card .label { font-size: .75rem; color: #64748b; margin-top: .25rem; }
        .chart-bar { margin-bottom: .75rem; }
        .chart-bar .bar-label { display: flex; justify-content: space-between; font-size: .8rem; margin-bottom: .25rem; }
        .chart-bar .bar-track { background: #e2e8f0; border-radius: 999px; height: 8px; overflow: hidden; }
        .chart-bar .bar-fill { background: var(--accent); height: 100%; border-radius: 999px; transition: width .3s; }
        .grid-2 { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.25rem; }
        .empty-state { text-align: center; padding: 2rem; color: #94a3b8; }
        .actions { display: flex; gap: .5rem; flex-wrap: wrap; }
        @media (max-width: 768px) {
            .sidebar { width: 100%; position: relative; min-height: auto; }
            .main { margin-left: 0; }
            body { flex-direction: column; }
        }
    </style>
    @stack('styles')
</head>
