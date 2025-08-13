<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($config['site_name'] ?? 'hitokoto') ?></title>
    <link rel="stylesheet" href="views/themes/<?= $config['theme'] ?>/assets/style.css">
</head>
<body>
    <div class="header">
        <h1><?= htmlspecialchars($config['site_name'] ?? 'ひとこと') ?></h1>
    </div>

    <div class="posts">
        <?php if (!empty($posts)): ?>
            <?php foreach ($posts as $post): ?>
                <article class="post">
                    <div class="post-meta">
                        投稿日: <?= date('Y年n月j日 G:i', strtotime($post['created'])) ?>
                    </div>
                    <div class="post-content">
                        <?= $post['body_html'] ?>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-posts">
                まだ記事がありません
            </div>
        <?php endif; ?>
    </div>
</body>
</html>