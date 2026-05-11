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
        $filename = 'applications.txt';
        $delimiter = '|';

        $name = $_POST['name'] ?? '';
        $surname = $_POST['surname'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $topic = $topics[$_POST['topic']] ?? '-';
        $payment = $payments[$_POST['payment']] ?? '-';
        $newsletter = !empty($_POST['newsletter']) ? 'Да' : 'Нет';

        $name = str_replace($delimiter, '', trim($name));
        $surname = str_replace($delimiter, '', trim($surname));
        $email = str_replace($delimiter, '', trim($email));
        $phone = str_replace($delimiter, '', trim($phone));
        $topic = str_replace($delimiter, '', trim($topic));
        $payment = str_replace($delimiter, '', trim($payment));

        $date = date('Y-m-d H:i:s');
        $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
        $status = 'active';

        $data = [$date, $ip, $name, $surname, $email, $phone, $topic, $payment, $newsletter, $status];
        $line = implode($delimiter, $data) . PHP_EOL;

        file_put_contents($filename, $line, FILE_APPEND);

        header('Location: hw5_ex1.php?success=' . (time() + 10));
        exit;
    }
}

require 'hw5_ex1.html';