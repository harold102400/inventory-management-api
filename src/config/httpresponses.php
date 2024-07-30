<?php

namespace Api\config;

class HttpResponses {
    public static $message = [
        'status' => '',
        'message' => ''
    ];

    public static function ok(string $res)
    {
        http_response_code(200);
        self::$message['status'] = 200;
        self::$message['message'] = $res;
        return self::$message;
    }
/**
 * modificada funcion created para que reciba el array de la respuesta despues de haberse creado un articulo
 */
    public static function created(array $res)
    {
        http_response_code(201);
        self::$message['status'] = 201;
        self::$message['message'] = $res;
        return self::$message;
    }

    public static function noContent()
    {
        http_response_code(204);
        self::$message['status'] = 204;
        return self::$message;
    }

    public static function notFound(string $res = 'Parece que estas perdido por favor verifica la documentacion')
    {
        http_response_code(404);
        self::$message['status'] = 404;
        self::$message['message'] = $res;
        return self::$message;
    }

    public static function serverError(string $res = 'Error interno del servidor')
    {
        http_response_code(500);
        self::$message['status'] = 500;
        self::$message['message'] = $res;
        return self::$message;
    }
}