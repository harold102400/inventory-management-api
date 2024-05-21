<?php


namespace Api\controllers;

use Api\models\ProductsModels;

class ProductController {
    public function getAllProducts()
    {
        try {
            $products = new ProductsModels();
            $data = $products->getAllProducts();
            json_encode($data);
        } catch (\Throwable $error) {
            var_dump($error);
        }
    }

    public function create($data)
    {
        try {
            $allData = [
                "codigo" => $data['codigo'],
                "nombre" => $data['nombre'],
                "tipo" => $data['tipo'],
                "marca" => $data['marca'],
                "precio" => $data['precio']
            ];

            $products = new ProductsModels();
            $products->create($allData);
            echo json_encode(204);
        } catch (\Throwable $error) {
            var_dump($error);
        }
    }

    public function getProduct($id)
    {
        try {
            $products = new ProductsModels();
            $product = $products->getProduct($id);
            if (!empty($product)) {
                echo json_encode($product);
                return;
            } else {
                echo json_encode(404);
            }
        } catch (\Throwable $error) {
            var_dump($error);
        }
    }

    public function update($id, $data)
    {
        try {
            $allData = [
                "id" => $id,
                "codigo" => $data['codigo'],
                "nombre" => $data['nombre'],
                "tipo" => $data['tipo'],
                "marca" => $data['marca'],
                "precio" => $data['precio']
            ];

            $products = new ProductsModels();
            $products->update($allData);
            echo json_encode(204);
        } catch (\Throwable $error) {
            var_dump($error);
        }
    }

    public function delete($id)
    {
        try {
            $product = new ProductsModels();
            $product->update($id);
            echo json_encode(204);
        } catch (\Throwable $error) {
            var_dump($error);
        }
    }

}