<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php');
    exit;
}

$config = require_once '../../config.php';
require_once '../../core/post.php';

$page = (int)($_GET['page'] ?? 1);
$perPage = 20;

$totalCount = getTotalPostsCount();
$postIds = getRecentPathsPaginated($page, $perPage);
$posts = getPosts($postIds);
$paginationInfo = getPaginationInfo($page, $perPage, $totalCount);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'logout') {
        session_destroy();
        header('Location: index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理画面 - <?= htmlspecialchars($config['site_name']) ?></title>
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }
        .header {
            background-color: #007cba;
            color: white;
            padding: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .site-title {
            margin: 0;
            font-size: 1.5rem;
        }
        .nav-links {
            display: flex;
            gap: 1rem;
            align-items: center;
        }
        .nav-links a, .nav-links button {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            background: none;
            border: 1px solid rgba(255, 255, 255, 0.3);
            cursor: pointer;
            font-size: 0.9rem;
        }
        .nav-links a:hover, .nav-links button:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }
        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: #007cba;
            margin-bottom: 0.5rem;
        }
        .stat-label {
            color: #666;
            font-size: 0.9rem;
        }
        .actions {
            margin-bottom: 2rem;
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }
        .btn {
            padding: 0.75rem 1.5rem;
            background-color: #007cba;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.9rem;
        }
        .btn:hover {
            background-color: #005a8b;
        }
        .btn-secondary {
            background-color: #6c757d;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }
        .posts-table {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .table-header {
            background-color: #f8f9fa;
            padding: 1rem;
            border-bottom: 1px solid #dee2e6;
            font-weight: bold;
        }
        .post-item {
            padding: 1rem;
            border-bottom: 1px solid #dee2e6;
            display: grid;
            grid-template-columns: 60px 120px 1fr auto;
            gap: 1rem;
            align-items: center;
        }
        .post-item:last-child {
            border-bottom: none;
        }
        .post-id {
            font-weight: bold;
            color: #007cba;
        }
        .post-date {
            color: #666;
            font-size: 0.9rem;
        }
        .post-content {
            color: #333;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .post-actions {
            display: flex;
            gap: 0.5rem;
        }
        .btn-small {
            padding: 0.25rem 0.5rem;
            font-size: 0.8rem;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        .btn-edit {
            background-color: #28a745;
            color: white;
        }
        .btn-delete {
            background-color: #dc3545;
            color: white;
        }
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 1rem;
            margin-top: 2rem;
        }
        .pagination a, .pagination span {
            padding: 0.5rem 1rem;
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            text-decoration: none;
            color: #007cba;
        }
        .pagination .current {
            background-color: #007cba;
            color: white;
        }
        .pagination a:hover {
            background-color: #f8f9fa;
        }
        @media (max-width: 768px) {
            .post-item {
                grid-template-columns: 1fr;
                gap: 0.5rem;
            }
            .post-actions {
                justify-content: flex-end;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="header-content">
            <h1 class="site-title"><?= htmlspecialchars($config['site_name']) ?> - 管理画面</h1>
            <nav class="nav-links">
                <a href="../">サイトを表示</a>
                <form method="POST" style="display: inline;">
                    <input type="hidden" name="action" value="logout">
                    <button type="submit">ログアウト</button>
                </form>
            </nav>
        </div>
    </header>

    <div class="container">
        <div class="stats">
            <div class="stat-card">
                <div class="stat-number"><?= $totalCount ?></div>
                <div class="stat-label">総投稿数</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= $paginationInfo['totalPages'] ?></div>
                <div class="stat-label">ページ数</div>
            </div>
        </div>

        <div class="actions">
            <a href="editor.php" class="btn">新規投稿</a>
            <a href="upload.php" class="btn btn-secondary">画像アップロード</a>
            <a href="settings.php" class="btn btn-secondary">設定</a>
        </div>

        <div class="posts-table">
            <div class="table-header">
                投稿一覧 (<?= $paginationInfo['currentPage'] ?> / <?= $paginationInfo['totalPages'] ?>ページ)
            </div>
            
            <?php if (empty($posts)): ?>
                <div style="padding: 2rem; text-align: center; color: #666;">
                    投稿がありません
                </div>
            <?php else: ?>
                <?php foreach ($posts as $post): ?>
                    <div class="post-item">
                        <div class="post-id">#<?= htmlspecialchars($post['id']) ?></div>
                        <div class="post-date"><?= date('Y/m/d H:i', strtotime($post['created'])) ?></div>
                        <div class="post-content"><?= htmlspecialchars(strip_tags($post['body_html'])) ?></div>
                        <div class="post-actions">
                            <button class="btn-small btn-edit" onclick="editPost(<?= $post['id'] ?>)">編集</button>
                            <button class="btn-small btn-delete" onclick="deletePost(<?= $post['id'] ?>)">削除</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <?php if ($paginationInfo['totalPages'] > 1): ?>
            <div class="pagination">
                <?php if ($paginationInfo['hasPrev']): ?>
                    <a href="?page=<?= $paginationInfo['currentPage'] - 1 ?>">← 前へ</a>
                <?php endif; ?>
                
                <span class="current">
                    <?= $paginationInfo['currentPage'] ?> / <?= $paginationInfo['totalPages'] ?>
                </span>
                
                <?php if ($paginationInfo['hasNext']): ?>
                    <a href="?page=<?= $paginationInfo['currentPage'] + 1 ?>">次へ →</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <script>
        function editPost(id) {
            window.location.href = 'editor.php?id=' + id;
        }

        function deletePost(id) {
            if (confirm('投稿 #' + id + ' を削除しますか？この操作は取り消せません。')) {
                // TODO: 削除機能を実装
                alert('削除機能は未実装です');
            }
        }
    </script>
</body>
</html>