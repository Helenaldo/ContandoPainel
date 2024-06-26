<?php

namespace App\Http\Controllers;

use App\Models\Processo;
use App\Http\Requests\StoreProcessoRequest;
use App\Http\Requests\UpdateProcessoRequest;

class ProcessoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProcessoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Processo $processo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProcessoRequest $request, Processo $processo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Processo $processo)
    {
        //
    }
}
