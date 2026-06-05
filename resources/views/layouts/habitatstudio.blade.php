<!DOCTYPE html>
<html lang="es" class="scroll-smooth"> <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HabitatStudio - Encuentra alojamiento cómodo</title>

    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 64 64%22><defs><linearGradient id=%22a%22 x1=%220%25%22 y1=%220%25%22 x2=%22100%25%22 y2=%22100%25%22><stop offset=%220%25%22 stop-color=%22%232563eb%22/><stop offset=%22100%25%22 stop-color=%22%234338ca%22/></linearGradient></defs><rect width=%2264%22 height=%2264%22 rx=%2216%22 fill=%22url(%23a)%22/><text x=%2250%25%22 y=%2250%25%22 font-family=%22sans-serif%22 font-size=%2240%22 font-weight=%22bold%22 fill=%22%23fff%22 text-anchor=%22middle%22 dominant-baseline=%22central%22>HS</text></svg>" type="image/svg+xml">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/habitatstudio.css') }}">
        @if(config('app.cursor_effects', true))
            @include('partials.cursor_effects')
        @endif
    </style>
</head>

<body class="bg-slate-50 text-gray-800 antialiased">

    <div class="cursor-dot hidden lg:block"></div>
    <div class="cursor-outline hidden lg:block"></div>
    <div class="cursor-ripple hidden lg:block"></div>

    @include('partials.nav_hs')

    <main class="pt-20">@yield('content')</main>

    @include('partials.footer_hs')

    @include('partials.scripts_hs')

</body>
</html>
