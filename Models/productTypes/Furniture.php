<?php

namespace Models\productTypes;

use Models\Product;

class Furniture extends Product
{

    // protected $attribute; 

    public function validateTypeAttribute($inputs)
    {

        if (!$inputs['height'] || !$inputs['width'] || !$inputs['length']) {
            return "Please set the height";
        }

        if (!is_numeric($inputs['height']) ) {
            return "Please set the height correctly";
        }
        if (!is_numeric($inputs['width']) ) {
            return "Please set the width correctly";
        }
        if (!is_numeric($inputs['length']) ) {
            return "Please set the length correctly";
        }

        $this->setAttribute($inputs);

        return "";
    }

    public function setAttribute($inputs)
    {

        $this->attribute = 'Dimensions: ' . $inputs['height'] . 'x' . $inputs['width'] . 'x' . $inputs['length'] . ' CM';
    }
}
