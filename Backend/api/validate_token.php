<?php

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require '..\..\vendor\autoload.php';
include_once '..\..\vendor\firebase\php-jwt\src\BeforeValidException.php';
include_once '..\..\vendor\firebase\php-jwt\src\ExpiredException.php';
include_once '..\..\vendor\firebase\php-jwt\src\SignatureInvalidException.php';
include_once '..\..\vendor\firebase\php-jwt\src\JWT.php';
use \Firebase\JWT\JWT;
use Firebase\JWT\Key;


$data = json_decode(file_get_contents("php://input"));
$jwt=isset($data->jwt) ? $data->jwt : "";
if ($decoded = validate($jwt)) {
    echo json_encode(array(
        "message" => "Access granted.",
        "data" => $decoded->data
    ));
}


function validate($jwt) {
    include '..\config\core.php';
    if($jwt){
        try {
            $headers = new stdClass();
            $decoded = JWT::decode($jwt, new Key($key, 'HS256'), $headers);
            http_response_code(200);
            return $decoded;
        } catch (Exception $e) {
            http_response_code(401);
            echo json_encode(array(
                "message" => "Access denied.",
                "error" => $e->getMessage()
            ));
        }
    } else {
        http_response_code(401);
        echo json_encode(array(
            "error" => "JWT empty"
        ));
    }
    return null;
}