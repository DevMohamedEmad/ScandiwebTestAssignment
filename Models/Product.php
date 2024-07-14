<?php

namespace Models;

use Core\DB;

class Product extends DB
{

    public $attribute;
    
    public $table = 'products';

    public $fillable = [
        'sku',
        'name',
        'price',
        'attribute'
    ];

    protected array $inputs;

    public function validateInputs($inputs)
    {
        $this->inputs = $inputs;

        $errors[] = $this->validateSku();
        $errors[] = $this->validateName();
        $errors[] = $this->validatePrice();
        $errors[] = $this->validateType();
        $errors[] = $this->validateTypeAttribute($inputs);
        
        return $errors;
    }

    public function validateSku()
    {

        if (!$this->inputs['sku']) {
            return "Please set the SKU";
        }
        return "";
    }
    public function validateName()
    {

        if (!$this->inputs['name']) {
            return "Please set the name";
        }

        if (!$this->inputs['name'] === "") {
            return "This name is invalid";
        }

        return "";
    }

    public function validatePrice()
    {
        if (!$this->inputs['price']) {
            return "Price was not provided!";
        }

        if (!filter_var($this->inputs['price'], FILTER_VALIDATE_FLOAT) || !(strlen($this->inputs['price']) > 0) || !(floatval($this->inputs['price']) >= 0)) {
            return "Invalid price!";
        }

        return "";
    }

    public function validateType()
    {
        if (!$this->inputs['product_type']) {
            return "Product Type was not provided!";
        }
        return "";
    }

    public function getAttribute(){
      
        return $this->attribute;
    }
}
