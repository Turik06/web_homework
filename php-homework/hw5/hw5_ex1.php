<?php

$topics = [
    'business' => 'Бизнес',
    'tech' => 'Технологии',
    'marketing' => 'Реклама и Маркетинг'
];

$payments = [
    'webmoney' => 'WebMoney',
    'yandex' => 'Яндекс.Деньги',
    'paypal' => 'PayPal',
    'card' => 'кредитная карта'
];

$success_msg = false;
if (!empty($_GET['success'])) {
    if ($_GET['success'] >= time()) {
        $success_msg = true;
    } else {
        header('Location: hw5_ex1.php');
        exit;
    }
}

$errors = [];
if (count($_POST)) {

    if (empty($_POST['name'])) {
        $errors['name'] = 'Поле с именем обязательно к заполнению!';
    }
    if (empty($_POST['surname'])) {
        $errors['surname'] = 'Поле с фамилией обязательно к заполнению!';
    }
    if (empty($_POST['email'])) {
        $errors['email'] = 'Поле с email обязательно к заполнению!';
    }
    if (empty($_POST['phone'])) {
        $errors['phone'] = 'Поле с телефоном обязательно к заполнению!';
    }
    if (empty($_POST['topic'])) {
        $errors['topic'] = 'Выберите тематику!';
    }
    if (empty($_POST['payment'])) {
        $errors['payment'] = 'Выберите метод оплаты!';
    }

    if (!$errors) {
        $dir = 'data/';

        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $filename = $dir . 'app-' . date('Y-m-d-H-i-s') . '-' . uniqid() . '.txt';

        $contents = 'Имя: ' . $_POST['name'] . "\n";
        $contents .= 'Фамилия: ' . $_POST['surname'] . "\n";
        $contents .= 'Email: ' . $_POST['email'] . "\n";
        $contents .= 'Телефон: ' . $_POST['phone'] . "\n";
        $contents .= 'Тематика: ' . ($topics[$_POST['topic']] ?? '-') . "\n";
        $contents .= 'Оплата: ' . ($payments[$_POST['payment']] ?? '-') . "\n";
        $contents .= 'Рассылка: ' . (!empty($_POST['newsletter']) ? 'Да' : 'Нет') . "\n";

        file_put_contents($filename, $contents);

        header('Location: hw5_ex1.php?success=' . (time() + 10));
        exit;
    }
}

require 'hw5_ex1.html';