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
include_once '..\lib\Parsedown.php';

use \Firebase\JWT\JWT;

$SNIPPET_TAGE_BASE_HTML = '<div class="p-5 w-screen">
<div class="relative w-1/2">
    <pre><code id="code-container" class="p-2 rounded-lg border border-cyan-800 ">
%s
    </code></pre>
    <div class="absolute top-0 right-0 p-2 px-4 bg-slate-600 rounded-bl-lg border-l border-b border-cyan-600">Copy</div>
    <div class="flex flex-initial pt-5">
        <div class="w-[10rem] h-fit text-slate-200 bg-slate-950 border border-[#0c6b98] shadow-lg shadow-[#0c6b98]/30 rounded-md">
            <div class="m-auto text-center p-2 justify-center text-2xl mb-5 border-b bg-[#0d88bc] border-[#0c6b98] shadow-sm shadow-[#0c6b98]/50">
                %s
            </div>
            <div id="tags-container" class="flex flex-wrap m-4 gap-2">
            </div>
        </div>
        <div id="doc-container" class="language-markdown overflow-auto p-2 mx-2 bg-zinc-950 text-slate-200">
        %s
        </div>
    </div>
</div>
</div>';

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
}