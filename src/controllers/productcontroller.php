<?php


namespace Api\controllers;

use Api\models\ProductsModels;

class ProductController {
    public function getAllProducts()
    {
        try {
            $products = new ProductsModels();
            $data = $products->getAllProducts();
            echo json_encode($data);
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
            $existingProduct = $products->getCodeFromDb($data["codigo"]);
            if ($existingProduct) {
                $error = [
                    "status" => 404,
                    "errorMessage" => "El codigo de este producto esta repetido!"
                ];
                echo json_encode($error, http_response_code($error["status"]));
                return;
            }
            $status = [
                "status" => 204,
            ];
            $products->create($allData);
            echo json_encode($status, http_response_code($status["status"]));
        } catch (\Throwable $error) {
            echo $error;
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
                $status = [
                    "status" => 404,
                    "msg" => "el producto con el id $id no existe!"
                ];
                echo json_encode($status["msg"], http_response_code($status["status"]));
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
            echo json_encode(http_response_code(204));
        } catch (\Throwable $error) {
            var_dump($error);
        }
    }

    public function delete($id)
    {
        try {
            $product = new ProductsModels();
            $product->delete($id);
            echo json_encode(http_response_code(204));
        } catch (\Throwable $error) {
            var_dump($error);
        }
    }

}