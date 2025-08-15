<?php
session_start();

$config = require_once '../../config.php';

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';
    
    if (password_verify($password, $config['admin_password'])) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'パスワードが正しくありません。';
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理画面ログイン - <?= htmlspecialchars($config['site_name']) ?></title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .login-container {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        .login-title {
            text-align: center;
            margin-bottom: 2rem;
            color: #333;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #555;
        }
        input[type="password"] {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
            box-sizing: border-box;
        }
        .btn {
            width: 100%;
            padding: 0.75rem;
            background-color: #007cba;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #005a8b;
        }
        .error {
            color: #d63384;
            margin-top: 0.5rem;
            text-align: center;
        }
        .site-link {
            text-align: center;
            margin-top: 1rem;
        }
        .site-link a {
            color: #007cba;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1 class="login-title">管理画面ログイン</h1>
        
        <form method="POST">
            <div class="form-group">
                <label for="password">パスワード:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="btn">ログイン</button>
            
            <?php if (isset($error)): ?>
                <div class="error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
        </form>
        
        <div class="site-link">
            <a href="../">← サイトに戻る</a>
        </div>
    </div>
</body>
</html>