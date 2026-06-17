@extends('layouts.app')
@section('contenido')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-slate-900">Testimonios</h2>
            <p class="text-slate-500 mt-2">Quienes ya han encontrado un hogar cómodo.</p>
        </div>
        @foreach ($casas as $casa)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="p-8 rounded-2xl bg-white border border-slate-100 shadow-sm">
                    <div class="flex items-center gap-4 mb-4">
                        <div>
                        @if ($casa->propietario->avatar_url == null)
                            <img src="https://randomuser.me/api/portraits/women/44.jpg"
                            class="w-12 h-12 rounded-full object-cover">
                        @else
                            <img src="{{$casa->propietario->avatar_url}}"
                            class="w-12 h-12 rounded-full object-cover">
                        @endif
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-900">{{ $casa->propietario->name }}</h4>
                            <p class="text-xs text-slate-500">{{ $casa->propietario->descripcion_perfil }}</p>
                        </div>
                    </div>
                    <div class="text-yellow-400 text-sm mb-3">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                            class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                    </div>
                    <p class="text-slate-600 text-sm">{{ $casa->testimonios->contenido }}</p>
                </div>
        @endforeach
    @endsection
