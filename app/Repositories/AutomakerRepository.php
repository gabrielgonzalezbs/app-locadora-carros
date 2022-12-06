<?php
namespace App\Repositories;

class AutomakerRepository extends MainRepository
{

    /**
     * fields that can be used for where search
     *
     * @var array
     */
    public $queryFields = [
        'name',
        'id',
    ];

}

?>
