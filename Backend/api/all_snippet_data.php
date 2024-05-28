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

$SNIPPET_HTML = '<div class="rounded-xl bg-[#189bcc] border border-[#84d5f5] shadow-md shadow-[#84d5f5]/25 p-3 px-5 break-inside-avoid-column">
<div class="text-4xl font-semibold">%s</div>
<div class="flex gap-2 my-2">
    %s
</div>
<div class="font-medium">
    %s
</div>
<div class="mt-5">
    %s
</div>
<div class="flex gap-2 flex-row-reverse">
    <div class="p-2 px-3 bg-[#bee7f9] border-2 rounded-md">
        Ver
    </div>
    <div class="p-2 px-3 border-2 rounded-md">
        copiar
    </div>
</div>
</div>';

$SNIPPET_TAGE_BASE_HTML = '<div class="px-2 text-slate-950 font-semibold rounded-lg bg-[%s] w-fit">
%s
</div>';

$GET_ALL_SNIPPETS = 'select * from codesnack.snippets s left join codesnack.snippet_tags st on s.id = st.snippet_id left join codesnack.tags t on t.id = st.tag_id';

if (!isset($_COOKIE[$cookie_name])) {
    http_response_code(401);
    exit();
}
http_response_code(200);
$database = new Database();
$db = $database->getConnection();

$stmt = $db->prepare($GET_ALL_SNIPPETS);
$stmt->execute();
$last_uuid = '';
$tags = '';
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    error_reporting(E_ERROR | E_PARSE);
    if ($row['id'] == $last_uuid ) {
        echo $row;
        $tags = $tags . sprintf($SNIPPET_TAGE_BASE_HTML, '#' . $row['color'], $row['tagname']);
        continue;
    } else {
        $tags = $tags . sprintf($SNIPPET_TAGE_BASE_HTML, '#' . $row['color'], $row['tagname']);
        echo sprintf($SNIPPET_HTML, $row['name'], $tags, $row['description'], 'Modificada hace ' . round((time() - strtotime($row['last_edit'])) / (60 * 60 * 24)) . ' dias');
        $tags = '';
        $last_uuid = $row['id'];
    }
    error_reporting(E_WARNING | E_PARSE);
    exit();
}

