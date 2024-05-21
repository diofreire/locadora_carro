<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

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
    public function index(Request $request)
    {
        $marcas = [];

        // Verifica se há parametros na busca
        if($request->has('modelos')) {
            $marcas = $this->marca->with('modelos:id,'.$request->modelos);
        } else {
            $marcas = $this->marca->with('modelos');
        }

        // filtro
        if($request->has('filtro')) {
            $filtros = explode(',', $request->filtro);
            foreach ($filtros as $key => $condicao) {
                $c = explode(':', $condicao);
                $marcas = $marcas->where($c[0], $c[1], $c[2]);
            }
        }

        if($request->has('where')) {
            $marcas = $marcas->selectRaw($request->where)->get();
        } else {
            $marcas = $marcas->get();
        }

        return $marcas;
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
        $request->validate($this->marca->rules(), $this->marca->feedback());

        // Trativa da imagens
        $imagem = $request->file('imagem');

        return $this->marca->create([
            'nome' => $request->nome,
            'imagem' => $imagem->store('imagens', 'public')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $idMarca
     * @return JsonResponse
     */
    public function show(int $idMarca)
    {
        $dados = $this->marca->with('modelos')->find($idMarca) ?? false;

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

        // Validação do Methodo PATCH
        if($request->method() === 'PATCH') {
            $regras = [];

            // percorre todas regras definidas
            foreach ($marca->rules() as $input => $regra) {
                // Coleta apenas as regras aplicaveis aos parametros enviados
                if(array_key_exists($input, $request->all())) {
                    $regras[$input] = $regra;
                }
            }
        } else {
            $regras = $this->marca->rules();
        }

        $request->validate($regras, $this->marca->feedback());

        // Trativa da imagens
        $imagem = $request->file('imagem');

        // Removendo imagem atualizada
        if($imagem) {
            Storage::disk('public')->delete($marca->imagem);
        }

        //preenche o objeto $marca com os dados do request
        $marca->fill($request->all());
        $marca->imagem = $imagem->store('imagens', 'public');
        $marca->save();

        /*$marca->update([
            'nome' => $request->nome,
            'imagem' => $imagem->store('imagens', 'public')
        ]);*/

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
            // Removendo arquivo da imagem
            Storage::disk('public')->delete($marca->imagem);

            $marca->delete();
            return ['msg' => 'A marca foi deletada'];
        } else {
            return response()->json(['error' => 'Não encontrado'], 404);
        }
    }
}
