<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Marca extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'marcas';
    protected $fillable = ['nome', 'imagem'];

    /**
     * Regras de validação do Model
     * @return array[]
     */
    public function rules(): array
    {
        return [
           'nome' => 'required|unique:marcas,nome,'.$this->id.'|min:3',
           'imagem' => 'required|file|mimes:png,jpge'
       ];
    }

    /**
     * @return array[]
     */
    public function feedback(): array
    {
        return [
            'required' => 'O campo :attribute precisa ser preenchido',
            'nome.unique' => 'O nome da marca já existe',
            'nome.min' => 'O campo :attribute precisa ter no mínimo 3 caracteres',
            'imagem.mimes' => 'O arquivo deve ser uma imagem do tipo PNG ou JPEG'
        ];
    }
}
