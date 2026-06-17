@extends('layouts.habitatstudio')

@section('content')
<section id="inicio" class="relative min-h-[90vh] flex items-center bg-white overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-blue-50 via-white to-indigo-50 z-0"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
        <div class="text-left py-10">
            <div class="inline-flex items-center px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-bold mb-6 border border-blue-200">
                <span class="flex h-2 w-2 relative mr-2">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                </span>
                #1 plataforma para quienes estudian fuera
            </div>

            <h1 class="text-4xl md:text-6xl font-extrabold text-slate-900 mb-6 flex flex-col gap-2 md:gap-4 leading-tight">
                <span>
                    Encuentra alojamiento <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">cómodo</span>,
                </span>
                <span>
                    Vive con más seguridad.
                </span>
            </h1>

            <p class="text-lg text-slate-500 mb-8 leading-relaxed max-w-lg">
                No hace falta dar vueltas bajo el sol. Solo navega, reserva y simplemente muévete.
            </p>

            <form action="{{ route('casas.index') }}" method="GET" class="bg-white p-2 rounded-full shadow-xl border border-gray-100 flex items-center max-w-md w-full relative z-20">
                <div class="pl-6 flex-1">
                    <input type="text" name="keyword" placeholder="¿En qué zona buscas alojamiento?" class="w-full text-sm outline-none text-gray-700 placeholder-gray-400 bg-transparent">
                </div>
                <button type="submit" class="bg-slate-900 text-white rounded-full px-6 py-3 font-bold text-sm hover:bg-blue-700 transition shadow-md hover:shadow-blue-500/30">
                    Buscar
                </button>
            </form>
        </div>

        <div class="hidden md:block relative">
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-72 h-72 bg-blue-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
            <img src="https://images.unsplash.com/photo-1505691938895-1758d7feb511?q=80&w=2070&auto=format&fit=crop" class="relative rounded-3xl shadow-2xl transform rotate-2 hover:rotate-0 transition duration-500 border-4 border-white" alt="Ilustrasi Kos">
        </div>
    </div>
</section>

<section id="recomendaciones" class="py-20 bg-slate-50">
@include('partials.recomendaciones')
</section>

<section id="ventajas" class="py-20 bg-white">
@include('partials.ventajas')
</section>

<section id="testimonios" class="py-20 bg-slate-50">
@include('partials.testimonios', ['testimonios' => $testimonios])
</section>

@endsection
