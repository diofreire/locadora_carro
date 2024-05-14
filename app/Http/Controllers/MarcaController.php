<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MarcaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Collection|Marca[]
     */
    public function index()
    {
        return Marca::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        return Marca::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param Marca $marca
     * @return Marca
     */
    public function show(Marca $marca)
    {
        return $marca;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Marca $marca
     * @return bool
     */
    public function update(Request $request, Marca $marca)
    {
        return $marca->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Marca $marca
     * @return string[]
     */
    public function destroy(Marca $marca)
    {
        $marca->delete();
        return ['msg' => 'A marca foi deletada'];
    }
}
