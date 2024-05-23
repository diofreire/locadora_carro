<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Locacao extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'locacoes';
    protected $fillable = [
        'cliente_id',
        'carro_id',
        'data_inicio_periodo',
        'data_final_previsto_periodo',
        'data_final_realizado_periodo',
        'valor_diaria',
        'km_inicial',
        'km_final'
    ];

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            'cliente_id' => 'required|exists:clientes,id',
            'carro_id' => 'required|exists:carros,id',
            'data_inicio_periodo' => 'required|date',
            'data_final_previsto_periodo' => 'required|date',
            'data_final_realizado_periodo' => 'required|date',
            'valor_diaria' => 'required|numeric',
            'km_inicial' => 'required|numeric',
            'km_final' => 'required|numeric'
        ];
    }

    /**
     * @return array[]
     */
    public function feedback(): array
    {
        return [
            'required' => 'O campo :attribute precisa ser preenchido',
            'cliente_id.exists' => 'O Cliente informado não não existe',
            'carro_id.exists' => 'O carro informado não não existe',
            'date' => 'O campo :attribute precisa ser uma data válida',
            'numeric' => 'O campo :attribute precisa ser um número',
        ];
    }
}
