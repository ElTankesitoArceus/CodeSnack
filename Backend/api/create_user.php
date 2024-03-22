<?php
// required headers
header("Access-Control-Allow-Origin: http://localhost/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'c:\Users\aramosm\Documents\TFG\Backend\config\database.php';
include_once 'c:\Users\aramosm\Documents\TFG\Backend\api\objects\user.php';
$database = new Database();
$db = $database->getConnection();
$user = new User($db);
$data = json_decode(file_get_contents('php://input'));
$user->username = $data->username;
$user->password = $data->password;
$user->email = $data->email;
if(
    !empty($user->username) &&
    !empty($user->password) &&
    !empty($user->email) &&
    $user->create()
){
    // set response code
    http_response_code(200);
    // display message: user was created
    echo json_encode(array("message" => "User was created."));
}
// message if unable to create user
else{
    // set response code
    http_response_code(400);
    // display message: unable to create user
    echo json_encode(array("message" => "Unable to create user."));
}