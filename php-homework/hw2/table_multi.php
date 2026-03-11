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
        td, th {
            border: 1px solid #5a1f1f;
            width: 50px;
            height: 50px;
            text-align: center;
            font-size: 18px;
        }
        .header {
            background-color: #fcd5b4; 
            font-weight: bold;
        }
        .corner {
            background-color: #800000;
        }
        .diagonal {
            background-color: #ffff99; 
        }
    </style>
</head>
<body>

<?php
echo "<table>\n";
for ($i = 0; $i <= 10; $i++) {
    echo "<tr>\n";
    for ($j = 0; $j <= 10; $j++) {
        if ($i == 0 && $j == 0) {
            echo "<th class='corner'></th>";
        }
        elseif ($i == 0) {
            echo "<th class='header'>" . $j . "</th>";
        }
        elseif ($j == 0) {
            echo "<th class='header'>" . $i . "</th>";
        }
        else {
            $result = $i * $j;
            
            if ($i == $j) {
                echo "<td class='diagonal'>" . $result . "</td>";
            } else {
                echo "<td>" . $result . "</td>";
            }
        }
    }
    
    echo "</tr>\n";
}

echo "</table>\n";
?>

</body>
</html>