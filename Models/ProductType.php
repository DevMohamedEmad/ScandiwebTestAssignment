<?php
namespace Models;


class ProductType extends BaseModel{

    public static $table = 'product_types';

    public static $fillable = [
        'id',
        'name',
    ];
}



?>