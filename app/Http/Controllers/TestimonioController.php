<?php

namespace App\Http\Controllers;

use App\Models\Testimonio;
use Illuminate\Http\Request;

class TestimonioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $testimonios=Testimonio::all();
         return view('testimonios.index', compact('testimonios'));
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
        $testimonios=Testimonio::create($request->all());
        return redirect()->action([self::class,'show'],['id'=>$testimonios->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $testimonios = Testimonio::findOrFail($id);

        return view('testimonios.show')
            ->with('testimonio', $testimonios);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $testimonios = Testimonio::findOrFail($id);

        return view('testimonios.edit')
            ->with('testimonio', $testimonios);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $testimonios=Testimonio::findOrFail($id);
        $testimonios->update($request->all());
        return redirect()->action([self::class,'show'],['id'=>$testimonios->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $testimonios=Testimonio::findOrFail($id);
        $testimonios->delete();
        return redirect()->action([self::class,'index']);
    }
}
