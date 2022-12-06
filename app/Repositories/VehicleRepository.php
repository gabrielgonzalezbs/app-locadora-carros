<?php

namespace App\Repositories;

class VehicleRepository extends MainRepository
{

    /**
     * fields that can be used for where search
     *
     * @var array
     */
    public $queryFields = [
        'id',
        'car_model_id',
        'plaque',
        'available',
        'km',
    ];

}

?>
