<?php
namespace Models;

use Core\DB;

class ProductType extends DB{

    public $table = 'product_types';

    public $fillable = [
        'id',
        'name',

    ];
}



?>