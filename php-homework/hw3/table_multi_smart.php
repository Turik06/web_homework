<?php


/**
 * @param int $x
 * @param int $y
 * @return string 
 */
function generateTable($x = 10, $y = 10) {
    
    $x = min((int)$x, 50); 
    $y = min((int)$y, 50);
    
    $data =[];
    for ($i = 0; $i <= $y; $i++) {
        for ($j = 0; $j <= $x; $j++) {
            if ($i == 0 && $j == 0) {
                $data[$i][$j] = ''; 
            } elseif ($i == 0 || $j == 0) {
                $data[$i][$j] = $i + $j;
            } else {
                $data[$i][$j] = $i * $j;
            }
        }
    }
    
  
    $html = "<table>\n";
    
    foreach ($data as $i => $row) {
        $html .= "\t<tr>\n"; 
        
        foreach ($row as $j => $cell) {
            $class = ($i == $j && $i != 0) ? ' class="diagonal"' : '';
            
            $html .= "\t\t<td{$class}>{$cell}</td>\n";
        }
        
        $html .= "\t</tr>\n";
    }
    
    $html .= "</table>\n";
    
    return $html; 
}

$inputX = $_GET['x'] ?? 10;
$inputY = $_GET['y'] ?? 10;

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Динамическая таблица умножения</title>
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
            width: 45px;
            height: 45px;
            text-align: center;
            font-size: 16px;
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

    <?php echo generateTable($inputX, $inputY); ?>

</body>
</html>