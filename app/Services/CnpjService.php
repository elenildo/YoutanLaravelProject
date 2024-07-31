<?php

namespace App\Services;
use Illuminate\Http\Request;
use App\Models\Cnpj;
use App\Models\Cliente;

class CnpjService
{
    
    /**
     * Find all cnpjs by Cliente id.
     */
    public function findAllByClienteId(string $id)
    {
        return Cnpj::where('cliente_id', intval($id))->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $clienteId)
    {
        $cliente = Cliente::findOrFail($clienteId);
        $cnpj = Cnpj::where('cnpj', $request->cnpj)->first();
        
        if($cnpj != null){
            return response()->json([
                'message' => 'Este CNPJ já foi atribuído a esta ou outra empresa'
            ], 400);
        }

        $cnpj = [
            "cnpj" => $request->cnpj,
            "filial" => $request->filial,
            "ativo" => $request->ativo,
            "cliente_id" => $clienteId
        ];
        
        return Cnpj::create($cnpj);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($request, string $id)
    {
        $cnpj = Cnpj::findOrFail($id);
        $search = Cnpj::where('cnpj', $request->cnpj)->first();
        
        if($search != null){
            if($search->id != $id)
                return response()->json([
                    'message' => 'Este CNPJ já foi atribuído a esta ou outra empresa'
                ], 400);
        }

        $cnpj->cnpj = $request->cnpj;
        $cnpj->filial = $request->filial;
        $cnpj->ativo = $request->ativo;
        $cnpj->save();
        return $cnpj;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cliente = Cliente::find($id);
        if($cliente == null)
            return response()->json([
                'message' => 'Empresa não localizada'
            ], 404);
        
        return $cliente->destroy();
    }
}