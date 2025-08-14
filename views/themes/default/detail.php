<?php if ($post): ?>
<article class="post-detail">
    <div class="post-meta">
        投稿日: <?= date('Y年n月j日 G:i', strtotime($post['created'])) ?>
    </div>
    <div class="post-content">
        <?= $post['body_html'] ?>
    </div>
    <div class="post-actions">
        <a href="/">&larr; トップページに戻る</a>
    </div>
</article>
<?php else: ?>
<div class="error">
    記事が見つかりません
</div>
<?php endif; ?>