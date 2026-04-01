<?php

$dir = 'data/';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['delete']) && is_array($_POST['delete'])) {
    foreach ($_POST['delete'] as $filename) {
        $filepath = $dir . basename($filename); 
        
        if (file_exists($filepath) && is_file($filepath)) {
            unlink($filepath);
        }
    }
    $message = 'Выбранные заявки успешно удалены!';
}

$files = is_dir($dir) ? array_diff(scandir($dir), ['.', '..']) : [];

require 'hw5_ex2.html';