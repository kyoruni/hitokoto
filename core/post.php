<?php

function getRecentPaths(int $limit = 5): array {
    $path = __DIR__ . '/../data/timeline/recent.json';
    $ids  = json_decode(file_get_contents($path), true);

    return array_slice($ids, 0, $limit);
}

function getPosts(array $ids): array {
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

function getPost(int $id): ?array {
    $recentPath = __DIR__ . '/../data/timeline/recent.json';
    $recentIds = json_decode(file_get_contents($recentPath), true);
    
    $targetPath = null;
    foreach ($recentIds as $pathId) {
        if (basename($pathId) == $id) {
            $targetPath = $pathId;
            break;
        }
    }
    
    if ($targetPath === null) return null;
    
    $path = __DIR__ . "/../data/posts/{$targetPath}.json";
    
    if (!is_file($path)) return null;
    
    $data = json_decode(file_get_contents($path), true);
    if (!is_array($data)) return null;
    
    if (!isset($data['id'], $data['created'], $data['body_html'])) return null;
    
    return [
        'id'        => $data['id'],
        'created'   => $data['created'],
        'body_html' => $data['body_html'],
    ];
}