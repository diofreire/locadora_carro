<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MarcaController extends Controller
{

    public $marca;

    /**
     *
     * @param Marca $marca
     */
    public function __construct(Marca $marca)
    {
        $this->marca = $marca;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Collection|Marca[]
     */
    public function index()
    {
        return $this->marca->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        return $this->marca->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param int $idMarca
     * @return Marca
     */
    public function show(int $idMarca)
    {
        return $this->marca->find($idMarca);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $idMarca
     * @return bool
     */
    public function update(Request $request, int $idMarca)
    {
        $marca = $this->marca->find($idMarca);
        return $marca->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $idMarca
     * @return string[]
     */
    public function destroy(int $idMarca)
    {
        $marca = $this->marca->find($idMarca);
        $marca->delete();
        return ['msg' => 'A marca foi deletada'];
    }
}
