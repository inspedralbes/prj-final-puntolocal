<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoriaGeneral;

class CategoriaGeneralController extends Controller
{
    //
    public function getCategoriasGenerales()
    {
        $categorias = CategoriaGeneral::all();
        return response()->json($categorias);
    }
}
