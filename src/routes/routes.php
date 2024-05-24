<?php

use Api\controllers\ProductController;

$router = new \Bramus\Router\Router();


$router->get('/api', function(){
    echo "welcome";
});

$router->get('/api/products', function() {
    $products = new ProductController();
    $products->getAllProducts();
});

$router->get('/api/product/{id}', function($id) {
    $product = new ProductController();
    $product->getProduct($id);
});

$router->post('/api/product', function() {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    $product = new ProductController();
    $product->create($data);
    //stdclass investigar//
});

$router->put('/api/product/{id}', function($id) {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    $product = new ProductController();
    $product->update($id, $data);
});

$router->delete('/api/product/{id}', function($id) {
    $product = new ProductController();
    $product->delete($id);
});

$router->set404(function() {
    $error = [
        "status" => 404,
        "errorMessage" => "Esta ruta no existe!"
    ];
    echo json_encode($error, http_response_code($error["status"])); 
});


$router->run();