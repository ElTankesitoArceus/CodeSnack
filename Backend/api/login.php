<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'C:\xampp\htdocs\TFG\Backend\api\objects\user.php';
include_once 'C:\xampp\htdocs\TFG\Backend\config\database.php';

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

$data = json_decode(file_get_contents("php://input"));
$data->login=htmlspecialchars(strip_tags($data->email));
$user->getUser($data->login, $data->password);

$user->password = $data->password;