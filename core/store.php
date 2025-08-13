<?php

function get_recent_ids(int $limit = 5): array {
    $path = __DIR__ . '/../data/timeline/recent.json';
    $ids  = json_decode(file_get_contents($path), true);

    return array_slice($ids, 0, $limit);
}