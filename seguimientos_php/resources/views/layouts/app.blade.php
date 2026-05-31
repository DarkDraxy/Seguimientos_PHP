<!DOCTYPE html>
<html lang="es">
<head>
    @include('layouts.head')
</head>
<body>
    @include('layouts.sidebar')

    @include('layouts.main')

    @stack('scripts')
</body>
</html>
