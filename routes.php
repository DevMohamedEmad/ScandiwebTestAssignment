<?php

use controllers\ProductController;

$routes = match ($_SERVER['REQUEST_METHOD']) {
    "POST" =>match ($_SERVER['REQUEST_URI']) {
        '/addProduct' => '',
        '/deleteBulkProducts' => (new ProductController)->deleteProducts($_POST['products']),
        '/checkSkuIsExist' => (new ProductController)->checkSkuIsNotExist($_POST['sku']),
        '/addproduct' => (new ProductController)->store($_POST),
        default => die('pad request url'),
    } ,
    'GET' => match ($_SERVER['REQUEST_URI']) {
        '/' =>(new ProductController)->list(),
        '/addProduct' => (new ProductController)->create(),
        default => die('pad request url')
    },
    default => die('pad method')
}


?>
