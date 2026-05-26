<?php
session_start();

require_once 'config/db.php';
require_once 'models/User.php';

$userModel = new User($dbo);

$action = $_GET['action'] ?? 'login';
$error = '';

if ($action === 'logout') {
    session_destroy();
    header('Location: auth.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($action === 'register') {
        if ($userModel->register($username, $password)) {
            header('Location: auth.php?action=login&success=1');
            exit;
        } else {
            $error = 'Пользователь с таким именем уже существует или произошла ошибка.';
        }
    } elseif ($action === 'login') {
        $userId = $userModel->authenticate($username, $password);
        if ($userId) {
            $_SESSION['user_id'] = $userId;
            header('Location: index.php');
            exit;
        } else {
            $error = 'Неверное имя пользователя или пароль.';
        }
    }
}

if ($action === 'register') {
    include 'views/register.php';
} else {
    include 'views/login.php';
}