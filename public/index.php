<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/Ig.php';

header('Content-Type: application/json; charset=utf-8');

function jsonResponse(int $code, $data): void {
    http_response_code($code);
    echo json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    exit;
}

set_exception_handler(function () {
    jsonResponse(500, ['error' => 'Internal Server Error']);
});

$type = $_GET['type'] ?? '';
$url  = $_GET['url'] ?? '';

if ($type === '' || $url === '') {
    jsonResponse(400, ['error' => 'Missing type or url parameter']);
}

if (!filter_var($url, FILTER_VALIDATE_URL)) {
    jsonResponse(400, ['error' => 'Invalid URL format']);
}

$postPattern    = '#^https?://(www\.)?instagram\.com/(p|reel|tv)/([A-Za-z0-9_-]+)/?#i';
$profilePattern = '#^https?://(www\.)?instagram\.com/([A-Za-z0-9._]+)/?(?:\?.*)?$#i';

$ig = new Ig(__DIR__ . '/../storage/cookies.txt');

try {

    if ($type === 'post') {

        if (!preg_match($postPattern, $url)) {
            jsonResponse(400, ['error' => 'Invalid Instagram post URL']);
        }

        $result = $ig->getPost($url);

    } elseif ($type === 'profile') {

        if (!preg_match($profilePattern, $url)) {
            jsonResponse(400, ['error' => 'Invalid Instagram profile URL']);
        }

        $result = $ig->getProfile($url);

    } else {
        jsonResponse(400, ['error' => 'Invalid type']);
    }

    jsonResponse(200, $result);

} catch (Throwable $e) {
    jsonResponse(500, ['error' => 'Request failed']);
}
?>