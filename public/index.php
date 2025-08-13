<?php

date_default_timezone_set('Asia/Tokyo');

$config = require __DIR__ . '/../config.php';
$theme = $config['theme'] ?? 'default';

require __DIR__ . '/../core/post.php';
$ids = get_recent_paths($config['posts_per_page']);
$posts = get_posts($ids);

require __DIR__ . "/../views/themes/{$theme}/home.php";