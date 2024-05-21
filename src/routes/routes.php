<?php

$router = new \Bramus\Router\Router();


$router->get('/api', function(){});

$router->get('/api/products', function() {
    echo "All products";
});

$router->get('/api/product/{id}', function($id) {
    echo "Get one product $id";
});

$router->post('/api/product', function() {
    echo "Create product";
});

$router->put('/api/product/{id}', function($id) {
    echo "Update product with id $id";
});

$router->delete('/api/product/{id}', function($id) {
    echo "Delete product with id $id";
});

$router->set404(function() {
    $error = [
        "status" => 404,
        "errorMessage" => "Hubo un error interno jhajaj"
    ];
    echo json_encode($error, http_response_code($error["status"])); 
});


$router->run();