<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-end mb-12">
        <div>
            <h2 class="text-3xl font-bold text-slate-900">Recomendaciones de alojamientos</h2>
            <p class="text-slate-500 mt-2">Favoritos en tu zona (selección aleatoria).</p>
        </div>
        <a href="{{ route('casas.index') }}" class="text-blue-600 font-bold text-sm hover:underline">Ver todo <i class="fa-solid fa-arrow-right ml-1"></i></a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @foreach($casas as $casa)
        <div class="bg-white rounded-2xl shadow-sm hover:shadow-2xl hover:-translate-y-1 transition duration-300 overflow-hidden border border-gray-100 group flex flex-col h-full">
            <div class="relative h-56 overflow-hidden flex-shrink-0">
                <img src="{{ $casa->imagen_url }}" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700">

                <div class="absolute top-4 left-4 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider text-slate-800 shadow-sm">
                    {{ $casa->tipo }}
                </div>

                <div class="absolute top-4 right-4 bg-slate-900/80 backdrop-blur px-2 py-1 rounded-lg text-xs font-bold text-yellow-400 shadow-sm flex items-center gap-1">
                    <i class="fa-solid fa-star"></i>
                    <span>{{ $casa->valoracion }}</span>
                </div>
            </div>
            <div class="p-6 flex flex-col flex-1">
                <div class="flex-1">
                    <h3 class="text-lg font-bold text-slate-900 line-clamp-1 mb-2">{{ $casa->nombre_casa }}</h3>
                    <p class="text-slate-500 text-sm mb-4 flex items-center">
                        <i class="fa-solid fa-location-dot text-red-500 mr-2"></i> {{ $casa->ubicacion }}
                    </p>
                    <div class="flex flex-wrap gap-2 mb-4">
                        @foreach(array_slice(explode(',', $casa->instalaciones), 0, 3) as $instalaciones)
                            <span class="text-[10px] bg-slate-100 text-slate-600 px-2 py-1 rounded border border-slate-200">{{ $instalaciones }}</span>
                        @endforeach
                        @if(count(explode(',', $casa->instalaciones)) > 3)
                            <span class="text-[10px] bg-slate-100 text-slate-600 px-2 py-1 rounded border border-slate-200">+{{ count(explode(',', $casa->instalaciones)) - 3 }}</span>
                        @endif
                    </div>
                </div>
                <div class="flex justify-between items-center border-t border-slate-100 pt-4 mt-auto">
                    <div>
                        <div class="text-lg font-bold text-blue-600">€ {{ number_format($casa->precio, 0, ',', '.') }}</div>
                        <div class="text-xs text-slate-400">/ mes</div>
                    </div>

                    <a href="{{ route('casas.show', $casa->id) }}" class="bg-slate-900 text-white px-5 py-2 rounded-lg text-sm font-bold hover:bg-blue-700 transition shadow-lg transform hover:-translate-y-0.5 hover:shadow-blue-500/30">
                        Ver
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
