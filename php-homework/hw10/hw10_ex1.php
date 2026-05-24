<?php
session_start(); // Инициализация сессии
require_once 'Application.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $app = new Application($_POST);
    $errors = $app->validate();

    if (empty($errors)) {
        $app->save();
        $_SESSION['success'] = true;
        unset($_SESSION['form_data'], $_SESSION['errors']);
    } else {
        $_SESSION['errors'] = $errors;
        $_SESSION['form_data'] = $_POST;
    }
    header('Location: hw9_ex1.php'); // Редирект для предотвращения повторной отправки 
    exit;
}

$success = $_SESSION['success'] ?? false;
$errors = $_SESSION['errors'] ?? [];
$form_data = $_SESSION['form_data'] ?? [];

unset($_SESSION['success'], $_SESSION['errors']);

require 'hw9_ex1.html'; // Подключение оригинального HTML 