@foreach ($testimonios as  $testimonio)

@endforeach
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-16">
        <h2 class="text-3xl font-bold text-slate-900">Testimonios</h2>
        <p class="text-slate-500 mt-2">Quienes ya han encontrado un hogar cómodo.</p>
    </div>

    @foreach ($testimonios as $testimonio )
 <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="p-8 rounded-2xl bg-white border border-slate-100 shadow-sm">
            <div class="flex items-center gap-4 mb-4">
                <img src={{$testimonio?->user->avatar_url ?? "https://randomuser.me/api/portraits/women/44.jpg"}} class="w-12 h-12 rounded-full object-cover">
                <div>
                    <h4 class="font-bold text-slate-900">{{$testimonio?->user->name ?? "No hay usuario"}}</h4>
                    <p class="text-xs text-slate-500">Estudiante de CIFP Carlos III</p>
                </div>
            </div>
            <div class="text-yellow-400 text-sm mb-3">
                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
            </div>
            <p class="text-slate-600 text-sm">{{$testimonio->contenido}}</p>
        </div>
        
    </div>
    @endforeach

</div>
{{-- Parte a) — Controlador - [ ] Modificar el método del controlador que carga  home.blade.php  para que
recupere solo los testimonios con  fecha_aprobacion  no nula y los pase a la vista.
Parte b) — Partial - [ ] Modificar  resources/views/partials/testimonios.blade.php  para que
recorra la colección de testimonios y muestre para cada uno: - Avatar ( avatar_url ). Si es  null ,
mostrar un avatar por defecto. - Nombre del usuario y  descripcion_perfil . - Contenido del
testimonio.
Cómo saber que está bien: la portada muestra los testimonios del seeder con  fecha_aprobacion
rellena y no muestra los que están pendientes. --}}
