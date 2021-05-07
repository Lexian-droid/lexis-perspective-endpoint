    <?php
error_reporting(0);

// Load config
include "config/config.php";

// GET values

$token = $_GET["token"];
$msg = $_GET["msg"];
$mode = strtoupper($_GET["mode"]);

// Base64

if($_GET["b64"] == 1) {
    $b64 = $_GET["b64"];
}

// output setup

// ⬇ You may not edit these responses ⬇
$response = "";
$response->info->title = "Lexi's Perspective Endpoint";
$response->info->version = "1.0.0";
$response->info->about = "This is a custom endpoint handler for Google's PerspectAPI.";
$response->info->tos = "By using this API you agree to Google's ToS.";
$response->info->website = "https://www.timewisely.net";
$response->info->repo = "https://github.com/Lexian-droid/lexis-perspective-endpoint";
// ⬆ You may not edit these responses ⬆

$response->api->mode = "$mode";

if(strlen($secKey) > 0) {
    if(!$_GET["key"] == $secKey){
        $response->api->error = "Invalid key!";
        die(json_encode($response,JSON_UNESCAPED_SLASHES));
    }
}

if(isset($b64)) {
    $msg = base64_decode($msg);
    $response->api->input = "$msg";
} else{
    $response->api->input = "$msg";
}

$response->api->result = "0";
$response->api->error = null;

// Pattern check

if(!isset($token) or !strlen($token) > 0) {
    $response->api->error = "Invalid token!";
    die(json_encode($response,JSON_UNESCAPED_SLASHES));
}
if(!isset($mode) or !strlen($mode) > 0) {
    $response->api->error = "Invalid mode!";
    die(json_encode($response,JSON_UNESCAPED_SLASHES));
}
if(!isset($msg) or !strlen($msg) > 0) {
    $response->api->error = "Invalid string!";
    die(json_encode($response,JSON_UNESCAPED_SLASHES));
}

// Setup

$endpoint = "https://commentanalyzer.googleapis.com/v1alpha1/comments:analyze?key=$token";

$data -> comment->text = $msg;
$data -> requestedAttributes -> $mode = null;

$data = json_encode($response,JSON_UNESCAPED_SLASHES);

$options = array(
    'http' => array(
            'method' => 'POST',
            'header' => "Content-type: application/json\r\n" .
                'Content-length: '.strlen($data)."\r\n".
                'Content-Type: application/json\r\n',
            'content' => $data
    )
);

$context = stream_context_create($options);
$result = file_get_contents($endpoint, false, $context);
if ($result === FALSE) {
    $response->api->error = "API Request error!";
    die(json_encode($response,JSON_UNESCAPED_SLASHES));
}

$resultParse = json_decode($result);

// Parse Result

$response->api->error = $resultParse->error->message;

$response->api->result = round($resultParse->attributeScores->$mode->summaryScore->value*100);

// End

die(json_encode($response,JSON_UNESCAPED_SLASHES));
?>
