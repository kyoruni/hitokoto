<?php

function get_recent_paths(int $limit = 5): array {
    $path = __DIR__ . '/../data/timeline/recent.json';
    $ids  = json_decode(file_get_contents($path), true);

    return array_slice($ids, 0, $limit);
}

function get_posts(array $ids): array {
  $posts = [];
  foreach ($ids as $id) {
    $path = __DIR__ . "/../data/posts/{$id}.json";

    if (!is_file($path)) continue;

    $data = json_decode(file_get_contents($path), true);
    if (!is_array($data)) continue;

    if (!isset($data['id'], $data['created'], $data['body_html'])) continue;

    $posts[] = [
      'id'        => $data['id'],
      'created'   => $data['created'],
        'body_html' => $data['body_html'],
    ];
  }

  return $posts;
}