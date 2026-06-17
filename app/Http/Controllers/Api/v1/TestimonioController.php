<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TestimonioResource;
use App\Models\Testimonio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestimonioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Testimonio $testimonios)
    {
        $testimonios = DB::table('testimonios')
                        ->whereNotNull('fecha_aprobacion')
                        ->orderByDesc('fecha_aprobacion')
                        ->get();

        //dd($testimonios);

        if(!$testimonios){
            return response()->json([
                'message' => 'El testimonio no existe'
            ], 404);
        } else{
            return response()->json([
                'message' => 'El testimonio existe'
            ], 200);
        }

        return new TestimonioResource($testimonios);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Testimonio $testimonio)
    {
        $this->authorize('create', $testimonio);

        $testimonio = $request->validate([
            'user_id' => $request->auth()->user()->id(),
            'contenido' => 'required',
            'valoracion' => 'required',
            'casa_id' => 'required|unique:casas,id',
            'descripcion' => 'required'
        ]);

        $testimonio = Testimonio::create($testimonio);
        return new TestimonioResource($testimonio);
    }

    /**
     * Display the specified resource.
     */
    public function show(Testimonio $testimonio, $id)
    {
        $testimonio = DB::table('testimonios')
                        ->where('id' === $id);

        if(!$id){
            return response()->json([
                'message' => 'El testimonio no existe'
            ], 404);
        } else{
            return new TestimonioResource($testimonio);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Testimonio $testimonio)
    {
        $this->authorize('create', $testimonio);

        $testimonio = $request->validate([
            'user_id' => $request->auth()->user()->id(),
            'contenido' => 'required',
            'valoracion' => 'required',
            'casa_id' => 'required|unique:casas,id',
            'descripcion' => 'required'
        ]);

        $testimonio = Testimonio::create($testimonio);
        return new TestimonioResource($testimonio);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Testimonio $testimonio)
    {
        $this->authorize('create', $testimonio);


        $testimonio->delete();
        return redirect()->route('home')->with('success', 'Testimonio eliminado con éxito.');
    }
}
