<?php

namespace App\Services;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ClienteService
{

    /**
     * @return Illuminate\Database\Eloquent\Collection 
     */
    public function index() 
    {
        return Cliente::paginate(10);
    }

    /**
     * @param Request $request
     * @return Cliente
     */
    public function store(Request $request)
    {
        if(Cliente::where('razao_social', $request->razao_social)->count() > 0){
            return response()->json([
                'message' => 'Já existe um cliente com essa Razão Social'
            ], 400);
        }

        $cliente = [
            "razao_social" => $request->razao_social,
            "ativo" => $request->ativo,
            "slug" => Str::slug($request->razao_social, '-')
        ];
        
        return Cliente::create($cliente);
    }

    /**
     * @param string $id
     * @return Cliente
     */
    public function show(string $id)
    {
        return Cliente::findOrFail($id);
    }

    /**
     * @param Request $request
     * @param string $id
     * @return Cliente
     */
    public function update(Request $request, string $id)
    {
        $cliente = Cliente::findOrFail($id);
        $search = Cliente::where('razao_social', $request->razao_social)->first();
        
        if($search != null){
            if($search->id != $id)
                return response()->json([
                    'message' => 'Já existe um cliente com essa Razão Social'
                ], 400);
        }

        $cliente->razao_social = $request->razao_social;
        $cliente->ativo = $request->ativo;
        $cliente->slug = Str::slug($request->razao_social, '-');
        $cliente->save();
        return $cliente;
    }

    /**
     * @param string $id
     */
    public function destroy(string $id)
    {
        $cliente = Cliente::findOrFail($id);
        if($cliente == null){
            return response()->json([
                'message' => 'Cliente não encontrado'
            ], 404);
        }
        return $cliente->delete();
    }

    /**
     * @param string $id
     */
    public function findBySlug(string $slug)
    {
        return Cliente::where('slug', $slug)->first();
    }

}