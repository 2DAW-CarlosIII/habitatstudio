<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-16">
        <h2 class="text-3xl font-bold text-slate-900">Testimonios</h2>
        <p class="text-slate-500 mt-2">Quienes ya han encontrado un hogar cómodo.</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="p-8 rounded-2xl bg-white border border-slate-100 shadow-sm">

            @foreach ($testimonios as $testimonio)

                    <div class="flex items-center gap-4 mb-4">
                        <img href="{{ $testimonio->usuario->avatar_url }}" class="w-12 h-12 rounded-full object-cover">
                        <div>
                            <h4 class="font-bold text-slate-900">{{ $testimonio->usuario->name }}</h4>
                            <p class="text-xs text-slate-500">{{ $testimonio->usuario->descripcion_perfil }}</p>
                        </div>
                    </div>
                    <div class="text-yellow-400 text-sm mb-3">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                            class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                            class="fa-solid fa-star"></i>
                    </div>
                    <p class="text-slate-600 text-sm">{{ $testimonio->usuario->contenido }}</p>
            @endforeach
        </div>
    </div>
</div>
