<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\TestimonioResource;
use App\Models\Casa;
use App\Models\Testimonio;
use Illuminate\Http\Request;

class TestimonioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->fecha_aprobacion != null) {
            return TestimonioResource::collection(
                Testimonio::where('fecha_aprobacion')->orderBy($request->sort ?? 'fecha_aprobacion', $request->order ?? 'desc')
                    ->paginate($request->per_page)

            );
        }
    }

    public function showCasaTestimonio(Request $request, $casa)
    {
        if ($request->fecha_aprobacion != null) {
            return TestimonioResource::collection(
                Testimonio::where('casa_id', $casa)
                    ->orderBy($request->sort ?? 'id', $request->order ?? 'asc')
                    ->paginate($request->per_page)
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Testimonio $testimonio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Testimonio $testimonio)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Testimonio $testimonio)
    {
        //
    }
}
