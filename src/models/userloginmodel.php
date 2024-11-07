<?php

namespace Api\models;
use Api\database\ConnectDb;
use \PDO;

class UserLoginModel
{
    public $conn;

    public function __construct()
    {
        $instance = ConnectDb::getInstance();
        $this->conn = $instance->getConnection();
    }

    public function userLogin(array $login_data)
    {
        $query = "SELECT * FROM users WHERE username = :username";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            return null; // Maneja el error de preparación si es necesario
        }

        $stmt->execute([
            ":username" => $login_data["username"]
        ]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Devuelve el usuario si existe y la contraseña es válida
        if ($user && password_verify($login_data["password"], $user["password"])) {
            return $user;
        }


        return null; // Devuelve null si no se autentica
    }

    public function getUser(int $id)
    {
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        if ($stmt) {
            $stmt->execute(["id" => $id]);
            $rows = $stmt->fetchColumn();
            return $rows;
        }
    }

    public function createUser(array $data_from_form)
    {
        $sql = "";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->execute([
                "username" => $data_from_form['username'],
                "name" => $data_from_form['name'],
                "passoword" => $data_from_form['password']
            ]);
            return $this->getUsernameFromDB($data_from_form['username']);
        }
    }

    public function getUsernameFromDB(string $username)
    {
        $sql = "";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([":username" => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
