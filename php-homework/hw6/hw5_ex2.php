<?php

$file = 'applications.txt';
$message = '';
$delimiter = '|';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['delete'])) {
    if (file_exists($file)) {
        $lines = file($file); 
        $file_modified = false;

        foreach ($_POST['delete'] as $lineNumber) {
            $lineNumber = (int)$lineNumber;
            
            if (isset($lines[$lineNumber])) {
                $data = explode($delimiter, trim($lines[$lineNumber]));
                
                if (count($data) >= 10) {
                    $data[9] = 'deleted'; 
                    $lines[$lineNumber] = implode($delimiter, $data) . PHP_EOL; 
                    $file_modified = true;
                }
            }
        }

        if ($file_modified) {
            file_put_contents($file, implode("", $lines)); 
            $message = 'Выбранные заявки успешно удалены!';
        }
    }
}

$applications = []; 

if (file_exists($file)) {
    $lines = file($file);
    
    foreach ($lines as $index => $line) {
        $line = trim($line);
        if (empty($line)) continue;

        $data = explode($delimiter, $line);
        $status = $data[9] ?? '';
        
        if ($status !== 'deleted') {
            $applications[$index] = $data;
        }
    }
}

require 'hw5_ex2.html';