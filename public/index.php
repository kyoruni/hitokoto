<?php

date_default_timezone_set('Asia/Tokyo');

$config = require __DIR__ . '/../config.php';
$theme = $config['theme'] ?? 'default';

require __DIR__ . '/../core/post.php';
require __DIR__ . '/../core/view.php';

$ids = getRecentPaths($config['posts_per_page']);
$posts = getPosts($ids);

$template_file = __DIR__ . "/themes/{$theme}/home.php";
require __DIR__ . "/themes/layout.php";