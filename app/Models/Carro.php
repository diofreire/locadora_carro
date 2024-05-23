<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Carro extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'carros';
    protected $fillable = ['modelo_id', 'placa', 'disponivel', 'km'];

    /**
     * Regras de validação do Model
     * @return array[]
     */
    public function rules(): array
    {
        return [
            'modelo_id' => 'exists:modelos,id',
            'placa' => 'required',
            'disponivel' => 'required',
            'km' => 'required'
        ];
    }

    /**
     * @return array[]
     */
    public function feedback(): array
    {
        return [
            'required' => 'O campo :attribute precisa ser preenchido',
            'modelo_id.exists' => 'O modelo informado não não existe',
        ];
    }

    public function modelo() {
        return $this->belongsTo('App\Models\Modelo');
    }
}
