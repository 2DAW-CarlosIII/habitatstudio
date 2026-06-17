<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Testimonio;
use Illuminate\Http\Request;

class TestimonioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

       return  new TestimonioResource::collection();
        /* Crea un  TestimonioResource  que exponga:  id ,  contenido ,  valoracion ,  fecha_aprobacion , el
name  y  avatar_url  del usuario, y —si existe— el  nombre_casa  de la casa referenciada.
Implementa el endpoint público (sin autenticación */
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
