<?php
$host = 'mysql';
$dbname   = 'calendar_db';
$username = 'root';
$password = 'root';

try {
    // ВАЖНО: переменная должна называться $dbo
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    $dbo = new PDO($dsn, $username, $password);
    
    // Настройки для удобного вывода ошибок и работы с массивами
    $dbo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    die('Ошибка подключения к БД: ' . $e->getMessage());
}