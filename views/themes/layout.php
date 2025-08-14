<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($config['site_name'] ?? 'hitokoto') ?></title>
    <link rel="stylesheet" href="/themes/<?= $config['theme'] ?>/assets/style.css">
</head>
<body>
    <div class="header">
        <h1><a href="/"><?= htmlspecialchars($config['site_name'] ?? 'ひとこと') ?></a></h1>
    </div>

    <div class="content">
        <?= renderWithLayout($template_file, get_defined_vars()) ?>
    </div>
</body>
</html>