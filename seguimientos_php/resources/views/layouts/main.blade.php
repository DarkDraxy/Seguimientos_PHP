<div class="main">
        <header class="main-header">
            <h2>@yield('title')</h2>
            @hasSection('subtitle')
                <p>@yield('subtitle')</p>
            @endif
        </header>
        <div class="main-content">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @yield('content')
        </div>
</div>
