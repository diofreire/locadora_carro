<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'modelos';
    protected $fillable = ['nome'];

    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'nome' => 'required'
        ];
    }

    /**
     * @return array[]
     */
    public function feedback(): array
    {
        return [
            'required' => 'O campo :attribute precisa ser preenchido',
        ];
    }
}
