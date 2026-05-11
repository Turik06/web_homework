<?php
session_start();
require_once 'Application.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['delete'])) {
    Application::delete($_POST['delete']);
    $_SESSION['msg'] = 'Заявки удалены!';
    header('Location: hw9_ex2.php');
    exit;
}

$message = $_SESSION['msg'] ?? '';
unset($_SESSION['msg']);
$applications = Application::getAll(); // Чтение данных через метод класса

require 'hw9_ex2.html';