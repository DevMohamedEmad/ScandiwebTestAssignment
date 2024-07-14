<?php

namespace Controllers;

use Core\View;
use Models\Product;
use Models\ProductType;


class ProductController
{

    public function list()
    {

        $products = (new Product)->getData('sku');

        return View::load('product/list', [
            'products' => $products
        ]);
    }

    public function deleteProducts($productsId)
    {

        (new Product)->deleteBulk($productsId);

        header("Location: /",);
    }

    public function create()
    {

        $productTypes = (new ProductType)->getData();

        if(isset($_SESSION['errors'])){
            $errors =  $_SESSION['errors'] ;
            unset($_SESSION['errors']);
        }

        return View::load('product/create', [
            'product_types' => $productTypes,
            'errors' => $errors??[]
        ]);
    }

    public function checkSkuIsNotExist($sku)
    {

        $product = (new Product)->where('sku', $sku);
        if (count($product) > 0) {
            echo false;
        } else {
            echo true;
        }
    }

    public function store($request)
    {
        $prodName = "models\\productTypes\\" . $_POST['product_type'];

        if (class_exists($prodName)) {
            $product = new $prodName();
        }

        $validations = $product->validateInputs($request);

        $errors = array_filter($validations, function ($value) {
            return !empty($value);
        });

        if (!$errors) {

            $request['attribute'] = $product->getAttribute();

            (new Product)->create($request);


            header("Location: /");
        } else {

            $_SESSION['errors'] = $errors;
            header("Location: /addProduct");
        }
    }
}
