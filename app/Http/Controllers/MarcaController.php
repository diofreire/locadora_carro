<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
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
     * @return JsonResponse
     */
    public function show(int $idMarca)
    {
        $dados = $this->marca->find($idMarca) ?? false;

        return $dados ? $dados : response()->json(['error' => 'Não encontrado'], 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $idMarca
     * @return JsonResponse|Marca
     */
    public function update(Request $request, int $idMarca)
    {
        $marca = $this->marca->find($idMarca);
        if(!$marca) {
            return response()->json(['error' => 'Não encontrado'], 404);
        }

        $marca->update($request->all());
        return $marca;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $idMarca
     * @return JsonResponse | array
     */
    public function destroy(int $idMarca)
    {
        $marca = $this->marca->find($idMarca);
        if($marca) {
            $marca->delete();
            return ['msg' => 'A marca foi deletada'];
        } else {
            return response()->json(['error' => 'Não encontrado'], 404);
        }
    }
}
