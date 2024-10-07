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
        $search = @$_GET['search'] ?? '';
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
            $data = $products->getAllProducts($page, $limit, $search);
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
                "code" => $data['code'],
                "name" => $data['name'],
                "type" => $data['type'],
                "brand" => $data['brand'],
                "price" => $data['price']
            ];
            if ($allData["price"] < 0) {
                /* $error = [
                    "status" => 400,
                    "errorMessage" => "El price no puede ser negativo."
                ]; */
                echo json_encode(HttpResponses::notFound("The price cannot be negative."));
                return;
            }
            $products = new ProductsModels();
            $existingProduct = $products->getCodeFromDb($data["code"]);
            if ($existingProduct) {
                echo json_encode(HttpResponses::notFound("The code for this product is duplicated!"));
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
                echo json_encode(HttpResponses::notFound("The product with ID $id does not exist!"));
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
                "code" => $data['code'],
                "name" => $data['name'],
                "type" => $data['type'],
                "brand" => $data['brand'],
                "price" => $data['price']
            ];

            $products = new ProductsModels();
            $products->update($allData);
            echo json_encode(HttpResponses::ok("Product with code " . $data['code'] . " has been updated."));
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