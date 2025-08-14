<?php

date_default_timezone_set('Asia/Tokyo');

$config = require __DIR__ . '/../config.php';
$theme = $config['theme'] ?? 'default';

require __DIR__ . '/../core/post.php';
require __DIR__ . '/../core/view.php';

$page = max(1, (int)($_GET['page'] ?? 1));
$perPage = $config['posts_per_page'];

$ids = getRecentPathsPaginated($page, $perPage);
$posts = getPosts($ids);

$totalCount = getTotalPostsCount();
$pagination = getPaginationInfo($page, $perPage, $totalCount);

$template_file = __DIR__ . "/themes/{$theme}/home.php";
require __DIR__ . "/themes/layout.php";