<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Таблица умножения</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            margin-top: 50px;
        }
        table {
            border-collapse: collapse; 
        }
        td {
            border: 1px solid #5a1f1f;
            width: 50px;
            height: 50px;
            text-align: center;
            font-size: 18px;
        }
        table tr:first-child td,
        table tr td:first-child {
            background-color: #fcd5b4; 
            font-weight: bold;
        }
        table tr:first-child td:first-child {
            background-color: #800000;
        }
        .diagonal {
            background-color: #ffff99; 
        }
    </style>
</head>
<body>

<?php

$data =[];

for ($i = 0; $i <= 10; $i++) {
    for ($j = 0; $j <= 10; $j++) {
        
        if ($i == 0 && $j == 0) {
            $data[$i][$j] = ''; 
            continue;
        }
        
        if ($i == 0 || $j == 0) {
            $data[$i][$j] = $i + $j; 
        } else {
            $data[$i][$j] = $i * $j;
        }
    }
}
?>

<table>
    <?php foreach ($data as $i => $row): ?>
        <tr>
            <?php foreach ($row as $j => $cell): ?>
                
                <?php 
                $class = ($i == $j && $i != 0) ? 'diagonal' : ''; 
                ?>
                
                <td class="<?= $class ?>">
                    <?= $cell ?>
                </td>
                
            <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>