<?php

namespace App\Http\Controllers;

use App\Models\Testimonio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class TestimonioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Testimonio $testimonio)
    {
        Gate::authorize('view', $testimonio);

        $testimonio = DB::table('testimonios')->get();

        return $testimonio;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('testimonios.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $usuario = Auth::user();

        $testimonio = $request->validate([
            'contenido' => ['required'],
            'valoracion' => ['required|between:0,5'],
            'casa_id' => ['exists:casas,id']
        ]);

        $testimonio = Testimonio::create([
            'user_id' => $usuario->id,
            'fecha_aprobacion' => null
        ]);

        return redirect()->route('/testimonio', $testimonio);
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
        Gate::authorize('update', $testimonio);

        return view('testimonios.edit', compact($testimonio));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Testimonio $testimonio)
    {
        Gate::authorize('update', $testimonio);

        $testimonio->update([
            'contenido' => $request->contenido,
            'valoracion' => $request->valoracion,
            'fecha_aprobacion' => $request->fecha_aprobacion
        ]);

        return redirect()->route('/')->with('success', 'Testimonio editado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Testimonio $testimonio)
    {
        Gate::authorize('delete', $testimonio);

        $testimonio->delete();

        return redirect()->route('/testimonio')->with('success', 'Testimonio eliminado con éxito.');
    }
}
