<?php

namespace App\Http\Controllers;

use App\Http\Resources\TestimonioResource;
use App\Models\Testimonio;
use Illuminate\Http\Request;

class TestimonioController extends Controller
{
    public function index()
    {
        return view('partials.testimonios', [
            'testimonios' => Testimonio::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /*
        $testimonio  = new Testimonio();
        $testimonio ->codigo = $request->input('codigo');
        $testimonio ->nombre = $request->input('nombre');
        $testimonio ->save();

        return redirect()->route('familias.show', ['id' => $familiaProfesional->id]);
        */
    }


    public function create()
    {
         return view('testimonios.create');
    }
    /**
     * Display the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Testimonio $testimonio)
    {
        $testimonioData = json_decode($request->getContent(), true);
        $testimonio->update($testimonioData);

        return new TestimonioResource($testimonio);
    }
    /**
     * Remove the specified resource from storage.
     */
    /*
    public function destroy(Tarea $tarea, Evidencia $evidencia)
    {
        try {
            $evidencia->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error: ' . $e->getMessage()
            ], 400);
        }
    }
        */
}
