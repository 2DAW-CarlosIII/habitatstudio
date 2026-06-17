<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\TestimonioResource;
use App\Models\Casa;
use App\Models\Testimonio;
use App\Policies\CasaPolicy;
use App\Policies\TestimonioPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class TestimonioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $testimonios = Testimonio::where('fecha_aprobacion', '!=', null)->sortDesc();

        return new TestimonioResource($testimonios);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $usuario = Auth::user();

        Gate::authorize('create', Testimonio::class);

        $testimonio = json_decode($request->getContent(), true);

        $testimonio = Testimonio::create([
            'user_id' => $usuario->id,
            'fecha_aprobacion' => null
        ]);

        return response()->json(new TestimonioResource($testimonio), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Casa $casa, Testimonio $testimonio)
    {
        Gate::define('view', CasaPolicy::class);

        $testimonio_casa = Casa::with('testimonios')->get();

        return new TestimonioResource($testimonio_casa);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Testimonio $testimonio)
    {
        Gate::authorize('update', TestimonioPolicy::class);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Testimonio $testimonio)
    {
        //
    }
}
