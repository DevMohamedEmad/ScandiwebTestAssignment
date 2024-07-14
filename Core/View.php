<?php
namespace Core;

class View {

    public static function load($view, array $data){
        extract($data);

        $file = 'Views/'.$view.'.php';

        if(file_exists($file)){
            require $file;
        }else {
            die('this file not exist' .$file);
        }
    }
}

?>