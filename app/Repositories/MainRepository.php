<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class MainRepository
{

    /**
     * fields that can be used for where search
     *
     * @var array
     */
    public $queryFields = [];

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function filters($filters)
    {

        if (!empty($filters)) {

            foreach ($filters as $key => $filter) {

                if (in_array($key, $this->queryFields) && !empty($filter)) {
                    $this->model = $this->model->where($key, $filter);
                }

            }

        }

    }

    public function getResult()
    {
        return $this->model->get();
    }

    public function getResultPaginate($numRows = 5)
    {
        return $this->model->paginate($numRows);
    }

}


?>
