<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@400;500;600;700&family=Ubuntu:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Arima+Madurai:wght@900&family=Laila:wght@500;600;700&family=Nunito:wght@600;700;800;900&family=Sarala:wght@400;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ mix('css/main.css') }}">
   <title>What2Do</title>
</head>
<body>
@include('navigation/nav')
{{-- <main>     --}}
@yield('content')
    
    {{-- Scripts --}}
    {{-- <script src={{ asset('js/app.js') }} ></script>
    @stack('child-scripts') --}}
{{-- </main> --}}
</body>
</html>