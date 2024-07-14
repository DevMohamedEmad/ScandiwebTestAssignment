<?php

namespace Core;

use Config\DbConfigration;

class DB
{
    public $conn, $table, $fillable;

    public function __construct($table,$columns)
    {
        $this->conn = (new DbConfigration)->connectionWithDB();
        $this->table = $table;
        $this->fillable = $columns;
    }

    public function getData($order_by=null)
    {   
        if(in_array($order_by, $this->fillable) ){
            $query = "select * from `$this->table` Order By ".$order_by .' DESC';
        }else{

            $query = "select * from `$this->table`";
        }     
        
        $result = $this->conn->query($query);

        if (mysqli_num_rows($result) > 0) {

            while ($row = $result->fetch_assoc()) {
                $data_from_db[] = $row;
            }

            return $data_from_db;
        } else {
            return [];
        }
    }

    public function deleteBulk($idsToDelete)
    {
        $idsToDelete = explode(',', $idsToDelete[0]);

        $quotedArray = array_map(function ($item) {
            return "'" . $item . "'";
        }, $idsToDelete);

        $ids = implode(',', $quotedArray);
        $query = "DELETE FROM " . $this->table . " WHERE sku IN ($ids)";

        $result = $this->conn->query($query);
        return $result ? true : false;
    }

    public function where($col_name, $value){

        $query = "select * from `$this->table` where `$col_name`='$value'";
        
        $result = $this->conn->query($query);

        if (mysqli_num_rows($result) > 0) {

            while ($row = $result->fetch_assoc()) {
                $data_from_db[] = $row;
            }

            return $data_from_db;

        } else {
            return [];
        }
    }

    public function create(array $data){

        foreach ($this->fillable as $col) {
            $columns[]=$col;
            $values[]=$data[$col];
        }

        $placeholders = implode(", ", array_fill(0, count($values), "?"));

        $sql = "INSERT INTO `$this->table` (" . implode(", ", $columns) . ") VALUES ($placeholders)";

        $stmt = $this->conn->prepare($sql);

        $types = str_repeat("s", count($values));

        $stmt->bind_param($types, ...$values);
        
        $stmt->execute();
    }
}
