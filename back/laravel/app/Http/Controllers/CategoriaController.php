<?php
    namespace App\Http\Controllers;

    use App\Models\Categoria;
    use Illuminate\Http\Request;

    class CategoriaController extends Controller {
        public function index() {
            //
            $categorias = Categoria::all();
            return response()->json($categorias);
        }

        public function ComerciosOfCategorias($categoriaId){
            $categoria = Categoria::with('comercios')->find($categoriaId);

            if(!$categoria) {
                return response() -> json(['message' => 'No s\'ha trobar la categoria']);
            }

            return response()->json($categoria->comercios,200);
        }

        public function create() {
            //
        }

        public function store(Request $request) {
            //
        }

        public function show(Categoria $categoria) {
            //
        }

        public function edit(Categoria $categoria) {
            //
        }

        public function update(Request $request, Categoria $categoria) {
            //
        }

        public function destroy(Categoria $categoria) {
            //
        }
    }