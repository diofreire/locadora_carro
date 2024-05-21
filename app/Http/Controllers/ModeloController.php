<?php

namespace App\Http\Controllers;

use App\Models\Modelo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ModeloController extends Controller
{
    public $modelo;

    /**
     *
     * @param Modelo $modelo
     */
    public function __construct(Modelo $modelo)
    {
        $this->modelo = $modelo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Collection|Modelo[]
     */
    public function index(Request $request)
    {
        $modelos = [];

        // Verifica se há parametros na busca
        if($request->has('marca')) {
            $modelos = $this->modelo->with('marca:id,'.$request->marca);
        } else {
            $modelos = $this->modelo->with('marca');
        }

        // filtro
        if($request->has('filtro')) {
            $filtros = explode(',', $request->filtro);
            foreach ($filtros as $key => $condicao) {
                $c = explode(':', $condicao);
                $modelos = $modelos->where($c[0], $c[1], $c[2]);
            }
        }

        if($request->has('where')) {
            $modelos = $modelos->selectRaw($request->where)->get();
        } else {
            $modelos = $modelos->get();
        }

        return $modelos;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        // Validando parametros
        $request->validate($this->modelo->rules(), $this->modelo->feedback());

        // Trativa da imagens
        $imagem = $request->file('imagem');

        return $this->modelo->create([
            'marca_id' => $request->marca_id,
            'nome' => $request->nome,
            'imagem' => $imagem->store('imagens/modelos', 'public'),
            'numero_portas' => $request->numero_portas,
            'lugares' => $request->lugares,
            'air_bag' => $request->air_bag,
            'abs' => $request->abs
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $idModelo
     * @return JsonResponse
     */
    public function show(int $idModelo)
    {
        $dados = $this->modelo->with('marca')->find($idModelo) ?? false;

        return $dados ? $dados : response()->json(['error' => 'Não encontrado'], 404);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $idModelo
     * @return JsonResponse
     */
    public function update(Request $request, int $idModelo)
    {
        $modelo = $this->modelo->find($idModelo);

        if(!$modelo) {
            return response()->json(['error' => 'Não encontrado'], 404);
        }

        // Validação do Methodo PATCH
        if($request->method() === 'PATCH') {
            $regras = [];

            // percorre todas regras definidas
            foreach ($modelo->rules() as $input => $regra) {
                // Coleta apenas as regras aplicaveis aos parametros enviados
                if(array_key_exists($input, $request->all())) {
                    $regras[$input] = $regra;
                }
            }
        } else {
            $regras = $this->modelo->rules();
        }

        $request->validate($regras, $this->modelo->feedback());

        // Trativa da imagens
        $imagem = $request->file('imagem');

        // Removendo imagem atualizada
        if($imagem) {
            Storage::disk('public')->delete($modelo->imagem);
        }

        //preenche o objeto $marca com os dados do request
        $modelo->fill($request->all());
        $modelo->imagem = $imagem->store('imagens/modelos', 'public');
        $modelo->save();

        /*$modelo->update([
            'marca_id' => $request->marca_id,
            'nome' => $request->nome,
            'imagem' => $imagem->store('imagens/modelos', 'public'),
            'numero_portas' => $request->numero_portas,
            'lugares' => $request->lugares,
            'air_bag' => $request->air_bag,
            'abs' => $request->abs
        ]);*/

        return $modelo;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $idModelo
     * @return JsonResponse|string[]
     */
    public function destroy(int $idModelo)
    {
        $modelo = $this->modelo->find($idModelo);
        if($modelo) {
            // Removendo arquivo da imagem
            Storage::disk('public')->delete($modelo->imagem);

            $modelo->delete();
            return ['msg' => 'A marca foi deletada'];
        } else {
            return response()->json(['error' => 'Não encontrado'], 404);
        }
    }
}
