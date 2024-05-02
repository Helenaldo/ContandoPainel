<?php

namespace App\Http\Controllers;

use App\Http\Resources\CidadeResource;
use App\Models\Cidade;
use Illuminate\Http\Request;

class CidadesController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $cidades = Cidade::get();

        return CidadeResource::collection($cidades);
    }
}
