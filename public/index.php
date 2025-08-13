<?php

date_default_timezone_set('Asia/Tokyo');

$config = require __DIR__ . '/../config.php';
$theme = $config['theme'] ?? 'default';

require __DIR__ . "/../views/themes/{$theme}/home.php";