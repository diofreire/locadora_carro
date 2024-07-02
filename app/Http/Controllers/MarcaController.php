<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Repository\MarcaRepository;
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
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        // Repository
        $marcaRepository = new MarcaRepository($this->marca);

        if($request->has('modelos')) {
            $marcaRepository->selectWithAtributtes('modelos:id,'.$request->modelos);
        } else {
            $marcaRepository->selectWithAtributtes('modelos');
        }

        if($request->has('filtro')) {
            $marcaRepository->filtro($request->filtro);
        }

        if($request->has('where')) {
            $marcaRepository->selectRaw($request->where);
        }

        return response()->json($marcaRepository->getResultadoPaginado(5), 200);
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

        // Preenchendo objeto marca com todos dados do request
        $marca->fill($request->all());

        // se a imagem foi encaminhada na request
        if($request->file('imagem')) {
            // Remove arquivo antigo
            Storage::disk('public')->delete($marca->imagem);

            $imagem = $request->file('imagem');
            $marca->imagem = $imagem->store('imagens', 'public');
        }

        $marca->save();

        return response()->json($marca, 200);
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
