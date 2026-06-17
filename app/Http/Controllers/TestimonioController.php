<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTestimonioRequest;
use App\Http\Requests\UpdateTestimonioRequest;
use App\Models\Casa;
use App\Models\Testimonio;
use Illuminate\Support\Facades\Gate;


class TestimonioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {



        $user = auth()->user;


        $testimonios = Testimonio::where('user_id', $user->id)->orderByDesc('timestamps')->get();
        return view('testimonios.index', compact('testimonios'));
    }
    /* ndex  - [ ] Mostrar todos los testimonios del usuario autenticado (aprobados y pendientes),
ordenados por fecha de creación descendente. - [ ] Incluir en cada tarjeta el estado:  Aprobado  o
Pendiente .
create  y  store  - [ ] El formulario (ya existe en  resources/views/testimonios/create.blade.php ,
revisa qué le falta) debe incluir: - Desplegable con las casas disponibles + opción «Comentario general
sobre la plataforma» (valor vacío →  NULL  en  casa_id ). - Campo de texto para el contenido. - Campo
numérico para la valoración (0–5, paso 0.5). - [ ]
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {


        Gate::authorize('create',Testimonio::class);

        $casas = Casa::all();

        return view('testimonios.create', compact('casas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTestimonioRequest $request)
    {
        $user = auth()->user;
        /* Validar:  contenido  no vacío ·  valoracion  entre 0 y 5 ·  casa_id  existe en  casas  (si se
envía) */
        $request->validate([

            'casa_id' => 'exists:casas,id',
            'contenido' => 'required',
            'valoracion' => 'nullable|string|max:20',

        ]);


        if ($request->valoracion <= 0 && $request->valoracion >= 5 && $request->contenido === '') {
            return redirect()->route('testimonios.create');
        }

        $testimonio = [
            'user_id' => $user,
            'casa_id' => $request?->casa?->id,
            'contenido' => $request->contenido,
            'valoracion' => $request->contenido,

        ];
        Testimonio::create($testimonio);
        return redirect()->route('testimonios.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Testimonio $testimonio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Testimonio $testimonio)
    {



  Gate::authorize('edit', Testimonio::class);


        return view('testimonios.create', compact('casas'));

        /* edit  y  update  - [ ] Permitir editar un testimonio propio solo si no está aprobado
( fecha_aprobacion  es  NULL ). - [ ] Si ya está aprobado: redirigir al  index  >con mensaje de error.
destroy  - [ ] Eliminar el testimonio que coincida con el  id  y pertenezca al usuario autenticado */
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTestimonioRequest $request, Testimonio $testimonio)
    {

              $user = auth()->user;

        $request->validate([

            'casa_id' => 'exists:casas,id',
            'contenido' => 'required',
            'valoracion' => 'nullable|string|max:20',

        ]);


        if ($request->valoracion <= 0 && $request->valoracion >= 5 && $request->contenido === '') {
            return redirect()->route('testimonios.create');
        }

        $testimonio = [
            'user_id' => $user,
            'casa_id' => $request?->casa?->id,
            'contenido' => $request->contenido,
            'valoracion' => $request->contenido,

        ];
        Testimonio::updated($testimonio);
        return redirect()->route('testimonios.index');


/* Solo los usuarios con al menos una  booking  como  inquilino_id  pueden crear, editar o
eliminar testimonios. */
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Testimonio $testimonio)
    {
        Gate::authorize('delete',$testimonio);

        try {
            $testimonio->delete();
        } catch (\Exception $e) {
            return redirect()
                ->route('testimonio.index')
                ->with('error', 'No se puede eliminar el testimonio porque tiene datos asociados.');
        }

        return redirect()
            ->route('testimonio.index')
            ->with('status', 'testimonio eliminado correctamente.');
    }
}
