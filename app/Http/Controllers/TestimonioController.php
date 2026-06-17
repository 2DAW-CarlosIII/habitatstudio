<?php

namespace App\Http\Controllers;

use App\Http\Resources\TestimonioResource;
use App\Models\Testimonio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use ResourceBundle;

class TestimonioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {

        return TestimonioResource::collection(
            Testimonio::orderBy($request->sort ?? 'fecha_aprobacion', $request->order ?? 'desc')
            ->where('fecha_aprobacion', not(null))
            ->paginate($request->per_page));
    }

    public function testimonios($casa)
    {
        $testimonios = Testimonio::findOrFail($casa);

        /* O

            if (!Testimonio::with('casas')->exists();) {

                return response()->json(['error' => 'La casa no existe'], 404);

            }
        */

        return new TestimonioResource($testimonios);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'contenido' => 'required',
            'valoracion' => 'decimal:0,5',
            'casa_id' => 'required|exists:casas,id'
        ]);

        $request->fecha_aprobacion === null;

        $request->user_id === Auth::user()->id;

        $testimonio = Testimonio::create($request->all());

        return new TestimonioResource($testimonio);
    }

    /**
     * Display the specified resource.
     */
    public function show(Testimonio $testimonio, string $id)
    {
        return new TestimonioResource($testimonio);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Testimonio $testimonio, string $id)
    {
        $request->validate([
            'contenido' => 'required',
            'valoracion' => 'decimal:0,5',
            'casa_id' => 'required|exists:casas,id'
        ]);

        $testimonio->update($request->all());

        $testimonio->save();

        if ($request->fecha_aprobacion === null) {
            return response()->json(['error' => 'El testimonio no está aprobado'], 403);
        }



        return new TestimonioResource($testimonio);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($testimonio)
    {
        $testimonio->delete();

        return response()->json(null, 204);
    }


    public function approve(Request $request, $testimonio)
    {

        $testimonio->fecha_aprobacion === $request->fecha_aprobacion;

        if ($request->casa_id === null) {
            return response()->json(['error' => 'No tiene casa asignada'], 422);
        }


        return new TestimonioResource($testimonio);
    }
}
