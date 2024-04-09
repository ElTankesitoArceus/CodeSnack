<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require '..\..\vendor\autoload.php';
include_once '.\objects\user.php';
include_once '..\config\database.php';
include_once '..\config\core.php';
include_once '..\..\vendor\firebase\php-jwt\src\BeforeValidException.php';
include_once '..\..\vendor\firebase\php-jwt\src\ExpiredException.php';
include_once '..\..\vendor\firebase\php-jwt\src\SignatureInvalidException.php';
include_once '..\..\vendor\firebase\php-jwt\src\JWT.php';
use \Firebase\JWT\JWT;


$database = new Database();
$db = $database->getConnection();
$user = new User($db);

$data = json_decode(file_get_contents("php://input"));
$data->login=htmlspecialchars(strip_tags($data->login));
if ($user->getUser($data->login, $data->password)) {
    http_response_code(200);
    $token = array(
        "iat" => $issued_at,
        "exp" => $expiration_time,
        "iss" => $issuer,
        "data" => array(
            "id" => $user->id,
            "username" => $user->username,
            "email" => $user->email
        )
    );
    $jwt = JWT::encode($token, $key, 'HS256');
    echo json_encode(
        array(
            "message" => "Successful login.",
            "jwt" => $jwt
        )
    );
} else {
    http_response_code(401);
}

