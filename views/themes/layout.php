<?php
function render_with_layout($template_path, $data = []) {
    extract($data);
    
    ob_start();
    include $template_path;
    $content = ob_get_clean();
    
    return $content;
}
?>
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

    <div class="content">
        <?= render_with_layout($template_file, get_defined_vars()) ?>
    </div>
</body>
</html>