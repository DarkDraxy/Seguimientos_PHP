<aside class="sidebar">
        <div class="sidebar-header">
            <h1>Ejercicios MVC</h1>
            <p>PHP & Laravel — 10 aplicaciones</p>
        </div>
        <nav class="sidebar-nav">
            @foreach(config('exercises.menu') as $item)
                <a href="{{ route($item['route']) }}" class="{{ request()->routeIs(str_replace('.index', '.*', $item['route'])) ? 'active' : '' }}">
                    <span class="icon">{{ $item['icon'] }}</span>
                    <span>{{ $item['label'] }}</span>
                </a>
            @endforeach
        </nav>
        <div class="sidebar-footer">Arquitectura MVC · Laravel {{ app()->version() }}</div>
    </aside>
