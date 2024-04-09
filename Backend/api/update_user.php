<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require '..\..\vendor\autoload.php';
include_once '.\objects\user.php';
include_once '..\config\database.php';
include_once '..\config\core.php';
ob_start();
include_once '.\validate_token.php';
ob_get_clean();
include_once '..\..\vendor\firebase\php-jwt\src\BeforeValidException.php';
include_once '..\..\vendor\firebase\php-jwt\src\ExpiredException.php';
include_once '..\..\vendor\firebase\php-jwt\src\SignatureInvalidException.php';
include_once '..\..\vendor\firebase\php-jwt\src\JWT.php';

use \Firebase\JWT\JWT;

$database = new Database();
$db = $database->getConnection();
$user = new User($db);
$data = json_decode(file_get_contents("php://input"));
if ($jwt = isset($data->jwt) && $decoded = validate($jwt)) {
    if (sizeof((array)$data) > 1) {
        error_reporting(E_ERROR | E_PARSE);
        $user->username = $data->username ? $data->username : $decoded->data->username;
        $user->email = $data->email ? $data->email : $decoded->data->email;
        $user->password = $decoded->data->password ? crypt($decoded->data->password, '$1$vaKLBGUrYKqH$') : ''; //TODO change for env
        $user->id = $decoded->data->id;
        error_reporting(E_WARNING | E_PARSE);
        if ($user->update()) {
            // regenerate jwt will be here
        } else {
            http_response_code(401);
            echo json_encode(array("message" => "Unable to update user."));
        }
    } else {
        http_response_code(400);
        echo json_encode(array("message"=> "no data provided."));
    }
    
} else {
    http_response_code(400);
    echo json_encode(array("error" => "No valid token provided"));
}
