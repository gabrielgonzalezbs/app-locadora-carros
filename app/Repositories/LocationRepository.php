<?php

namespace App\Repositories;

class LocationRepository extends MainRepository
{

    /**
     * fields that can be used for where search
     *
     * @var array
     */
    public $queryFields = [
        'id',
        'client_id',
        'vehicle_id',
        'start_date_range',
        'end_date_range_expected',
        'end_date_range_real',
        'daily_value',
        'km_start',
        'km_end',
    ];

}

?>
