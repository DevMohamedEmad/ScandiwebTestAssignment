<?php
namespace Models\productTypes;

use Models\Product;

class DVD extends Product{


    public function validateTypeAttribute($inputs){

        if (!$inputs['size']) {
            return "Please set the size";
        }

        if (!is_numeric($inputs['size']) ) {
            return "Please set the size correctly";
        }

        $this->setAttribute($inputs['size']);

        return "";
    }

    public function setAttribute($size){

        $this->attribute = 'Size: ' . $size . ' CM';
    }
}