<div class="posts">
    <?php if (!empty($posts)): ?>
        <?php foreach ($posts as $post): ?>
            <article class="post">
                <div class="post-meta">
                    投稿日: <a href="/post.php/<?= $post['id'] ?>"><?= date('Y年n月j日 G:i', strtotime($post['created'])) ?></a>
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

<?php include __DIR__ . '/pagination.php'; ?>