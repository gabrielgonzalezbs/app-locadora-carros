<?php

namespace App\Repositories;

class CarModelRepository extends MainRepository
{

    /**
     * fields that can be used for where search
     *
     * @var array
     */
    public $queryFields = [
        'id',
        'automaker_id',
        'name',
        'image',
        'number_ports',
        'places',
        'air_bag',
        'abs',
    ];

}

?>
