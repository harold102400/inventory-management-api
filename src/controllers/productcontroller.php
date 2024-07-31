<?php


namespace Api\controllers;

use Api\helpers\ErrorLog;
use Api\helpers\HttpResponses;
use Api\models\ProductsModels;

class ProductController {
    public function getAllProducts()
    {
        $page = (int)@$_GET['page'] ?? 1;
        $limit = (int)@$_GET['limit'] ?? 10;
        $nameFilter = @$_GET['name'] ?? '';
        if ($page <= 0) {
            $page = 1;
        }
        if ($limit <= 0) {
           $limit = 10;
        }
        if ($limit > 100) {
            $limit = 100;
        }
        try {
            $products = new ProductsModels();
            $data = $products->getAllProducts($page, $limit, $nameFilter);
            echo json_encode($data);
        } catch (\Throwable $error) {
            echo json_encode(HttpResponses::serverError());
            ErrorLog::showErrors();
            error_log("Error message n" . $error);
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
            if ($allData["precio"] < 0) {
                /* $error = [
                    "status" => 400,
                    "errorMessage" => "El precio no puede ser negativo."
                ]; */
                echo json_encode(HttpResponses::notFound("El precio no puede ser negativo."));
                return;
            }
            $products = new ProductsModels();
            $existingProduct = $products->getCodeFromDb($data["codigo"]);
            if ($existingProduct) {
                echo json_encode(HttpResponses::notFound("El codigo de este producto esta repetido!"));
                return;
            }
            $product = $products->create($allData);
            echo json_encode(HttpResponses::created($product));
        } catch (\Throwable $error) {
            echo json_encode(HttpResponses::serverError());
            ErrorLog::showErrors();
            error_log("Error message n" . $error);
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
                echo json_encode(HttpResponses::notFound("el producto con el id $id no existe!"));
            }
        } catch (\Throwable $error) {
            echo json_encode(HttpResponses::serverError());
            ErrorLog::showErrors();
            error_log("Error message n" . $error);
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
            echo json_encode(HttpResponses::ok("Producto con codigo ".$data['codigo']. " ha sido actualizado"));
        } catch (\Throwable $error) {
            echo json_encode(HttpResponses::serverError());
            ErrorLog::showErrors();
            error_log("Error message n" . $error);
        }
    }

    public function delete($id)
    {
        try {
            $product = new ProductsModels();
            $product->delete($id);
            echo json_encode(HttpResponses::noContent());
        } catch (\Throwable $error) {
            echo json_encode(HttpResponses::serverError());
            ErrorLog::showErrors();
            error_log("Error message n" . $error);
        }
    }

}