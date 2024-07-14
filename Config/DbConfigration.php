<?php
namespace Config;

final class DbConfigration{

    public const DB_HOST ="localhost";
    public const DB_NAME ="Scandiweb";
    public const DB_PASSWORD ="";
    public const DB_USER ="root";

    public function connectionWithDB(){

        return mysqli_connect(self::DB_HOST, self::DB_USER, self::DB_PASSWORD, self::DB_NAME);
    }
}



?>