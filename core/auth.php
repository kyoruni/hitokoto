<?php

function requireAdminAuth(): void {
    session_start();
    
    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        header('Location: /admin/');
        exit;
    }
}

function isAdminLoggedIn(): bool {
    session_start();
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

function adminLogin(string $password): bool {
    $config = require __DIR__ . '/../config.php';
    
    if (password_verify($password, $config['admin_password'])) {
        session_start();
        $_SESSION['admin_logged_in'] = true;
        return true;
    }
    
    return false;
}

function adminLogout(): void {
    session_start();
    session_destroy();
}