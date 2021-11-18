<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ mix('css/main.css') }}">
    <title>What2Do</title>
</head>
<body>

    @yield('content')
    
    {{-- Scripts --}}
    <script src={{ asset('js/app.js') }} ></script>
    @stack('child-scripts')
</body>
</html>