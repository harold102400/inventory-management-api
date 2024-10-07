<?php

namespace Api\models;

use Api\database\ConnectDb;
use \PDO;

class ProductsModels {

    public $tableName = "products";
    public $conn;

    public function __construct()
    {
        $instance = ConnectDb::getInstance();
        $this->conn = $instance->getConnection();
    }

    public function getAllProducts(int $page, int $limit, string $search = ''){
        $offset = ( $page - 1 ) * $limit;
        
        $sql = "SELECT * FROM $this->tableName";

        if (!empty($search)) {
            /**
             * PDO::quote es un método que se utiliza específicamente para escapar y citar valores de cadenas de caracteres para su uso en consultas SQL.
             * Esto agrega comillas simples alrededor del valor $name y escapa cualquier carácter especial dentro del valor, asegurando que no pueda ser
             * utilizado para alterar la lógica de la consulta SQL.
             */
            $search = $this->conn->quote('%' . $search . '%');
            $sql.= " WHERE name LIKE $search";
        }
        $sql.= " LIMIT $limit OFFSET $offset;";
        
        $result = $this->conn->query($sql);

        if ($result) {
            $data = $result->fetchAll(PDO::FETCH_ASSOC);
            $countSql = "SELECT COUNT(*) as total FROM $this->tableName";

            if (!empty($search)) {
                /**
                 * LIKE $search: Se utiliza LIKE en SQL para comparar el campo nombre con el valor filtrado, 
                 * permitiendo así buscar nombres que contengan la cadena especificada ($search).
                 */
                $countSql .= " WHERE name LIKE $search";
            }


            $result = $this->conn->query($countSql);
            $totalCount = (int)$result->fetch(PDO::FETCH_ASSOC)['total'];
            return [
                'data' => $data,
                'totalCount' => $totalCount,
                'page' => $page,
                'limit' => $limit,
                'sql' => $sql
            ];
        }
    }
    /**
     * Modificada funcion de crear para que devuelva el codigo que se ha creado
     */
    public function create($data)
    {
        $sql = "INSERT INTO $this->tableName(code, name, type, brand, price) VALUES (:code, :name, :type, :brand, :price)";
        $result = $this->conn->prepare($sql);
        if ($result) {
            $result->execute([
                ":code" => $data["code"],
                ":name" => $data["name"],
                ":type" => $data["type"],
                ":brand" => $data["brand"],
                ":price" => $data["price"]
            ]);
            return $this->getCodeFromDB($data["code"]);
        } else {
            echo "err";
        }
    }

    public function getCodeFromDB(string $code)
    {
        $sql = "SELECT * FROM $this->tableName WHERE code = :code";
        $result = $this->conn->prepare($sql);
        $result->execute([":code" => $code]);
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    public function getProduct($id)
    {
        $sql = "SELECT * FROM $this->tableName WHERE id=:id";
        $result = $this->conn->prepare($sql);
        if ($result) {
            $result->execute([":id" => $id]);
            $data = $result->fetch(PDO::FETCH_ASSOC);
            return $data;
        } else {
            echo "err";
        }
    }

    public function update($data)
    {
        $sql = "UPDATE $this->tableName SET code=:code, name=:name, type=:type, brand=:brand, price=:price WHERE id=:id";
        $result = $this->conn->prepare($sql);
        if ($result) {
            $result->execute([
                "id"=> $data["id"],
                ":code" => $data["code"],
                ":name" => $data["name"],
                ":type" => $data["type"],
                ":brand" => $data["brand"],
                ":price" => $data["price"]
            ]);
        }else {
            echo "err";
        }
    }

    public function delete($id)
    {
        $sql = "DELETE FROM $this->tableName WHERE id=:id";
        $result = $this->conn->prepare($sql);
        if ($result) {
            $result->execute([
                "id" => $id
            ]);
        }else {
            echo "err";
        }
    }
}