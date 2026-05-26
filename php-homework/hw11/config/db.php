<?php
$host = 'mysql';
$dbname   = 'calendar_db';
$username = 'root';
$password = 'root';

try {
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    $dbo = new PDO($dsn, $username, $password);
    
   
    $dbo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    die('Ошибка подключения к БД: ' . $e->getMessage());
}