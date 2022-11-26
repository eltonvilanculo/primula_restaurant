<?php

namespace App\Http\Controllers;

use App\Http\Resources\Artigo as ArtigoResource;
use App\Models\Artigo as Artigo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArtigoController extends Controller
{public function index()
    {
    $artigos = Artigo::paginate(15);
    return ArtigoResource::collection($artigos);
}

    public function show($id)
    {
        $artigo = Artigo::findOrFail($id);
        return new ArtigoResource($artigo);
    }

    public function store(Request $request)
    {
        $artigo = new Artigo;
        $artigo->nome = $request->input('nome');
        $artigo->categoria = $request->input('categoria');
        $artigo->preco = $request->input('preco');

        if ($artigo->save()) {
            return new ArtigoResource($artigo);
        }
    }

    public function update(Request $request)
    {
        $artigo = Artigo::findOrFail($request->id);
        $artigo->nome = $request->input('nome');
        $artigo->categoria = $request->input('categoria');
        $artigo->preco = $request->input('preco');

        if ($artigo->save()) {
            return new ArtigoResource($artigo);
        }
    }

    public function destroy($id)
    {
        $artigo = Artigo::findOrFail($id);
        if ($artigo->delete()) {
            return new ArtigoResource($artigo);
        }

    }

    public function selectArt($id)
    {
        $data = DB::table('artigos')->join('categorias', 'artigos.id', '=', 'categorias.id')->select('artigos.id','artigos.nome')->get();
        
        // print_r($data);
        return response()->json($data);
    }
}
