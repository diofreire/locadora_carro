<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Modelo extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'modelos';
    protected $fillable = ['marca_id', 'nome', 'imagem', 'numero_portas', 'lugares', 'air_bag', 'abs'];

    /**
     * Regras de validação do Model
     * @return array[]
     */
    public function rules(): array
    {
        return [
            'marca_id' => 'exists:marcas,id',
            'nome' => 'required|unique:modelos,nome,'.$this->id.'|min:3',
            'imagem' => 'required|file|mimes:png,jpeg',
            'numero_portas' => 'required|integer|digits_between:1,5',
            'lugares' => 'required|integer|digits_between:1,20',
            'air_bag' => 'required|boolean',
            'abs' => 'required|boolean', //true, false, 1, 0, "1", "0"
        ];
    }

    /**
     * @return array[]
     */
    public function feedback(): array
    {
        return [
            'required' => 'O campo :attribute precisa ser preenchido',
            'marca_id.exists' => 'A marca informada não não existe',
            'nome.unique' => 'O nome do modelo já existe',
            'nome.min' => 'O campo :attribute precisa ter no mínimo 3 caracteres',
            'imagem.mimes' => 'O arquivo deve ser uma imagem do tipo PNG ou JPEG',
            'integer' => 'Digite um número inteiro válido',
            'numero_portas.digits_between' => 'O campo :attribute precisa ser entre 1 e 5',
            'lugares.digits_between' => 'O campo :attribute precisa ser entre 1 e 20',
            'boolean' => 'Valor inválido'
        ];
    }

    /**
     * Um MODELO percente a UMA MARCA
     * @return BelongsTo
     */
    public function marca() {
        return $this->belongsTo('App\Models\Marca');
    }
}
