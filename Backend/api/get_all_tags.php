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


$SNIPPET_TAGE_BASE_HTML = '<div class="px-2 text-slate-950 font-semibold rounded-lg bg-[%s] w-fit">
%s
</div>';

$GET_ALL_TAGS = 'SELECT * from tags';

if (!isset($_COOKIE[$cookie_name])) {
    http_response_code(401);
    exit();
}
http_response_code(200);
$database = new Database();
$db = $database->getConnection();

$stmt = $db->prepare($GET_ALL_TAGS);
$stmt->execute();
$last_uuid = '';
$tags = '';
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo sprintf($SNIPPET_TAGE_BASE_HTML, '#' . $row['color'], $row['name']);
}

