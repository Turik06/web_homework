<?php
$errors = [];
$success = false;

$data = [
    'name' => '', 'surname' => '', 'email' => '', 
    'phone' => '', 'topic' => '', 'payment' => '', 'newsletter' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data['name'] = trim($_POST['name'] ?? '');
    $data['surname'] = trim($_POST['surname'] ?? '');
    $data['email'] = trim($_POST['email'] ?? '');
    $data['phone'] = trim($_POST['phone'] ?? '');
    $data['topic'] = $_POST['topic'] ?? '';
    $data['payment'] = $_POST['payment'] ?? '';
    $data['newsletter'] = isset($_POST['newsletter']) ? 'Да' : 'Нет';

    if (empty($data['name'])) $errors[] = "Введите имя.";
    if (empty($data['surname'])) $errors[] = "Введите фамилию.";
    if (empty($data['email'])) $errors[] = "Введите email.";
    if (empty($data['phone'])) $errors[] = "Введите телефон.";
    if (empty($data['topic'])) $errors[] = "Выберите тематику.";
    if (empty($data['payment'])) $errors[] = "Выберите метод оплаты.";

    if (empty($errors)) {
        $filename = 'app_' . uniqid() . '.txt';
        $content = "Дата: " . date('Y-m-d H:i:s') . "\n";
        foreach ($data as $key => $value) {
            $content .= "$key: $value\n";
        }
        
        file_put_contents($filename, $content);
        $success = true;
        $data = array_fill_keys(array_keys($data), '');
    }
}




    require 'hw5_ex1.html';