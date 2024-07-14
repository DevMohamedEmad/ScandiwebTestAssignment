<?php

namespace Models\productTypes;

use Models\Product;

class Book extends Product
{

    public function validateTypeAttribute($inputs)
    {
        if (!$inputs['weight']) {
            return "Please set the Weight";
        }

        if (!is_numeric($inputs['weight'])) {
            return "Please set the Weight correctly";
        }

        $this->setAttribute($inputs['weight']);
        return "";
    }

    public function setAttribute($weight)
    {
        $this->attribute = 'Weight: ' . $weight . 'KG';
     
    }
}
