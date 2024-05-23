<?php

namespace App\Http\Controllers;

use App\Models\Carro;
use App\Repository\CarroRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CarroController extends Controller
{
    public $carro;

    /**
     * @param Carro $carro
     */
    public function __construct(Carro $carro) {
        $this->carro = $carro;
    }


    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $carroRepository = new CarroRepository($this->carro);

        if($request->has('modelo')) {
            $carroRepository->selectWithAtributtes('modelo:id,'.$request->modelo);
        } else {
            $carroRepository->selectWithAtributtes('modelo');
        }

        if($request->has('filtro')) {
            $carroRepository->filtro($request->filtro);
        }

        if($request->has('where')) {
            $carroRepository->selectRaw($request->where);
        }

        return response()->json($carroRepository->getResultado(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate($this->carro->rules());

        $carro = $this->carro->create([
            'modelo_id' => $request->modelo_id,
            'placa' => $request->placa,
            'disponivel' => $request->disponivel,
            'km' => $request->km
        ]);

        return response()->json($carro, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $idCarro
     * @return JsonResponse
     */
    public function show(int $idCarro)
    {
        $carro = $this->carro->with('modelo')->find($idCarro);
        if($carro === null) {
            return response()->json(['erro' => 'Recurso pesquisado não existe'], 404) ;
        }

        return response()->json($carro, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $idCarro
     * @return JsonResponse
     */
    public function update(Request $request, int $idCarro)
    {
        $carro = $this->carro->find($idCarro);

        if($carro === null) {
            return response()->json(['erro' => 'Impossível realizar a atualização. O recurso solicitado não existe'], 404);
        }

        if($request->method() === 'PATCH') {

            $regrasDinamicas = array();

            //percorrendo todas as regras definidas no Model
            foreach($carro->rules() as $input => $regra) {

                //coletar apenas as regras aplicáveis aos parâmetros parciais da requisição PATCH
                if(array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }

            $request->validate($regrasDinamicas);

        } else {
            $request->validate($carro->rules());
        }

        $carro->fill($request->all());
        $carro->save();

        return response()->json($carro, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $idCarro
     * @return JsonResponse
     */
    public function destroy(int $idCarro)
    {
        $carro = $this->carro->find($idCarro);

        if($carro === null) {
            return response()->json(['erro' => 'Impossível realizar a exclusão. O recurso solicitado não existe'], 404);
        }

        $carro->delete();
        return response()->json(['msg' => 'O carro foi removido com sucesso!'], 200);
    }
}
