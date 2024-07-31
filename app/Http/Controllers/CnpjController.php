<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cnpj;
use App\Services\CnpjService;

class CnpjController extends Controller
{
    public function __construct(private readonly CnpjService $service)
    {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        return $this->service->store($request, $id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return $this->service->update($request, $id);
    }

    /**
     * Find all cnpjs by Cliente id.
     */
    public function findAllByClienteId(string $id)
    {
        return $this->service->findAllByClienteId($id);
    }
}
