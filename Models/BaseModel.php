<?php

namespace Models;

use Core\DB;

abstract class BaseModel
{

    public static function get($order_by = null)
    {
        return (new DB(table: static::$table, columns: static::$fillable))->getData($order_by);
    }

    public static function delete($ids)
    {
        return (new DB(table: static::$table, columns: static::$fillable))->deleteBulk($ids);
    }

    public static function find($col_name, $id)
    {
        return (new DB(table: static::$table, columns: static::$fillable))->where($col_name, $id);
    }

    public static function store($data)
    {
        return (new DB(table: static::$table, columns: static::$fillable))->create($data);
    }
}
