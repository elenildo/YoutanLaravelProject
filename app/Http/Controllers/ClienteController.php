<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ClienteService;

class ClienteController extends Controller
{

    public function __construct(private readonly ClienteService $service)
    {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = $this->service->index();
        return view('adm.clientes', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('adm.cliente');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->service->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->service->show($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cliente = $this->service->show($id);
        return view('adm.cliente', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return $this->service->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->service->destroy($id);
    }

    /**
     * Find one resource by slug
     */
    public function findBySlug(string $slug)
    {
        $cliente = $this->service->findBySlug($slug);

        return ($cliente == null) ? abort(404) : view('adm.cliente', compact('cliente'));
        
    }

}
