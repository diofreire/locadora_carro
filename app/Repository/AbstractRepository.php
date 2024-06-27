<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository
{
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @param $atributos
     * @return void
     */
    public function selectWithAtributtes(string $atributos) {
        $this->model = $this->model->with($atributos);
        //a query está sendo montada
    }

    /**
     * @param $filtros
     * @return void
     */
    public function filtro($filtros) {
        $filtros = explode(';', $filtros);

        foreach($filtros as $key => $condicao) {

            $c = explode(':', $condicao);
            $this->model = $this->model->where($c[0], $c[1], $c[2]);
            //a query está sendo montada
        }
    }

    /**
     * @param $atributos
     * @return void
     */
    public function selectRaw($atributos) {
        $this->model = $this->model->selectRaw($atributos);
    }

    /**
     * @return mixed
     */
    public function getResultado() {
        return $this->model->get();
    }

    /**
     * @return mixed
     */
    public function getResultadoPaginado($numeroPagina) {
        return $this->model->paginate($numeroPagina);
    }
}
