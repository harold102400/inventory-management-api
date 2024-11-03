<?php

namespace Api\controllers;

use Api\helpers\ErrorLog;
use Api\helpers\HttpResponses;
use Api\models\UserLoginModel;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class UserLoginController
{
    public function userLoginAuth($raw_data_from_endpoint)
    {
        try {
            $login_data = [
                "username" => $raw_data_from_endpoint['username'],
                "password" => $raw_data_from_endpoint['password'],
            ];

            $userLoginModel = new UserLoginModel();
            $data_from_db = $userLoginModel->userLogin($login_data);
            if ($data_from_db) {
                $now = time();
                $key = "mykey";
                $payload = [
                    'exp' => $now + 3600,
                    'id' => 5
                ];
                $jwt = JWT::encode($payload, $key, 'HS256');
                $array = ["token" => $jwt, "display_name"=> $data_from_db['name']];
                echo json_encode($array);
            }
            else if (!$data_from_db) {
                echo json_encode(HttpResponses::notFound("Invalid username or password"));
            }
        } catch (\Throwable $error) {
            echo json_encode(HttpResponses::serverError());
            ErrorLog::showErrors();
            error_log("Error message n" . $error);
        }
    }

    private function unauthorizedResponse($message = "Unauthorized")
    {
        echo json_encode(HttpResponses::unauthorizedUser($message));
        return;
    }

    /**La funcion getToken() obtiene las cabeceras(headers) que se envian dentro de la peticion 
     * usando la funcion interna apache_request_headers y se usa la funcion interna de la libreria decode para decodear el token*/
    public function getToken()
    {
        $headers = apache_request_headers();
        if (!isset($headers["Authorization"])) {
            return $this->unauthorizedResponse("Unauthenticated request");
        }
        $authorization = $headers["Authorization"];
        $authorization_array = explode(" ", $authorization);

        /**Esta línea comprueba que el array resultante tenga exactamente 2 elementos: 
         * El primer elemento (debería ser "Bearer").
         * El segundo elemento (debería ser el token en sí). */
        if (count($authorization_array) !== 2) {
            return $this->unauthorizedResponse("Token format is invalid");
        }
        $token = $authorization_array[1];
        try {
            $decoded_token = JWT::decode($token, new Key('mykey', 'HS256'));
            return $decoded_token;
        } catch (\Throwable $e) {
            return $this->unauthorizedResponse("Invalid token: " . $e->getMessage());
        }
    }

    /** esta funcion compara el id que viene del decoded token con el id de la base da datos
     * para saber si es el mismo, si es el mismo devuelve el id si no lo es devuelve false
    */
    public function validateToken()
    {
        $info_from_token_payload = $this->getToken();
        if (!$info_from_token_payload) {
           return;
        }
        $user = new UserLoginModel();
        //jwt_user tiene que validarse con un error en json aqui para que se muestre si el id no es el mismo que en la db
        $jwt_user = $user->getUser($info_from_token_payload->id);
        if (!$jwt_user) {
            return $this->unauthorizedResponse("This ID doesn't exist!");
        }
        return $jwt_user;
    }

}
