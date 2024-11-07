<?php

use Api\helpers\HttpResponses;
use Api\controllers\ProductController;
use Api\controllers\UserLoginController;

$router = new \Bramus\Router\Router();


$router->get('/api', function(){
    echo "welcome";
});

$router->get('/api/products', function() {
    $products = new ProductController();
    $products->getAllProducts();
});

$router->get('/api/products/{id}', function($id) {
    $product = new ProductController();
    $product->getProduct($id);
});

$router->post('/api/products', function() {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    $product = new ProductController();
    $product->create($data);
    //stdclass investigar//
});

$router->post('/api/auth', function(){
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    $new_user = new UserLoginController();
    $new_user->createUser($data);
});

$router->post('/api/auth', function(){
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    $user = new UserLoginController();
    $user->userLoginAuth($data);
});

$router->put('/api/products/{id}', function($id) {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    $product = new ProductController();
    $product->update($id, $data);
});

$router->delete('/api/products/{id}', function($id) {
    $product = new ProductController();
    $product->delete($id);
});

$router->set404(function() {
    echo json_encode(HttpResponses::notFound("Sorry, but the page you are looking for does not exist!"));
});


$router->run();