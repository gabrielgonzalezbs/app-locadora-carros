<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class MainRepository
{

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function filters($filters)
    {

        if (!empty($filters)) {

            foreach ($filters as $key => $filter) {

                $this->model = $this->model->where($key, $filter);

            }

        }

    }

    public function getResult()
    {
        return $this->model->get();
    }

}


?>
