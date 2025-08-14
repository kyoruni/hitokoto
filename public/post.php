<?php

date_default_timezone_set('Asia/Tokyo');

$config = require __DIR__ . '/../config.php';
$theme = $config['theme'] ?? 'default';

require __DIR__ . '/../core/post.php';
require __DIR__ . '/../core/view.php';

// PATH_INFOから記事IDを取得 (/post.php/3 のような形式)
$pathInfo = $_SERVER['PATH_INFO'] ?? '';
$pathInfo = trim($pathInfo, '/');

$id = (int)$pathInfo;

if ($id <= 0) {
    http_response_code(400);
    echo '無効な記事IDです';
    exit;
}

$post = getPost($id);

if ($post === null) {
    http_response_code(404);
    echo '記事が見つかりません';
    exit;
}

$template_file = __DIR__ . "/themes/{$theme}/detail.php";
require __DIR__ . "/themes/layout.php";