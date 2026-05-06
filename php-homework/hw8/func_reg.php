<?php

// Задание 1.
function getExtension($filename) {
    if (preg_match('/\.([^.]+)$/i', $filename, $matches)) {
        return $matches[1];
    }
    return null;
}

// Задание 2.
function getFileType($filename) {
    if (preg_match('/\.(zip|rar|tar|gz|7z)$/i', $filename)) {
        return 'Архив';
    } elseif (preg_match('/\.(mp3|wav|flac|ogg)$/i', $filename)) {
        return 'Аудиофайл';
    } elseif (preg_match('/\.(mp4|avi|mkv|mov)$/i', $filename)) {
        return 'Видеофайл';
    } elseif (preg_match('/\.(jpg|jpeg|png|gif|bmp|webp)$/i', $filename)) {
        return 'Картинка';
    }
    return 'Неизвестный тип';
}

// Задание 3.
function getTitleFromHtml($html) {
    if (preg_match('/<title>(.*?)<\/title>/is', $html, $matches)) {
        return $matches[1];
    }
    return null;
}

// Задание 4.
function getAllLinks($html) {
    preg_match_all('/<a\s+[^>]*href=(["\'])(.*?)\1/is', $html, $matches);
    return $matches[2];
}

// Задание 5.
function getAllImages($html) {
    preg_match_all('/<img\s+[^>]*src=(["\'])(.*?)\1/is', $html, $matches);
    return $matches[2];
}

// Задание 6.
function highlightText($search, $text) {

    $pattern = '/' . preg_quote($search, '/') . '/iu';
    return preg_replace($pattern, '<strong>$0</strong>', $text);
}

// Задание 7.
function replaceSmiles($text) {
    $patterns = [
        '/:\)/',
        '/;\)/',
        '/:\(/'
    ];
    
    $replacements = [
        '<img src="smile.png" alt=":)">',
        '<img src="wink.png" alt=";)">',
        '<img src="sad.png" alt=":(">'
    ];
    
    return preg_replace($patterns, $replacements, $text);
}

// Задание 8.
function removeExtraSpaces($text) {
    return preg_replace('/ {2,}/', ' ', $text);
}


$task = $_POST['task'] ?? '1';
$input = $_POST['input_text'] ?? '';
$search_word = $_POST['search_word'] ?? '';
$result = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
   
    switch ($task) {
        
        case '1': 
            if (preg_match('/\.([^.]+)$/i', $input, $matches)) {
                $result = "Расширение: <b>" . $matches[1] . "</b>";
            } else {
                $result = "Расширение не найдено.";
            }
            break;

        case '2': 
            if (preg_match('/\.(zip|rar|tar|gz|7z)$/i', $input)) {
                $result = "Это <b>Архив</b>";
            } elseif (preg_match('/\.(mp3|wav|flac|ogg)$/i', $input)) {
                $result = "Это <b>Аудиофайл</b>";
            } elseif (preg_match('/\.(mp4|avi|mkv|mov)$/i', $input)) {
                $result = "Это <b>Видеофайл</b>";
            } elseif (preg_match('/\.(jpg|jpeg|png|gif|bmp)$/i', $input)) {
                $result = "Это <b>Картинка</b>";
            } else {
                $result = "Неизвестный тип";
            }
            break;

        case '3': 
            if (preg_match('/<title>(.*?)<\/title>/is', $input, $matches)) {
                $result = "Текст в теге: <b>" . htmlspecialchars($matches[1]) . "</b>";
            } else {
                $result = "Тег <title> не найден.";
            }
            break;

        case '4': 
            preg_match_all('/<a\s+[^>]*href=(["\'])(.*?)\1/is', $input, $matches);
            $result = "Ссылки:<br><b>" . implode("<br>", $matches[2]) . "</b>";
            break;

        case '5':
            preg_match_all('/<img\s+[^>]*src=(["\'])(.*?)\1/is', $input, $matches);
            $result = "Картинки:<br><b>" . implode("<br>", $matches[2]) . "</b>";
            break;

        case '6':
            if (!empty($search_word)) {
                $pattern = '/' . preg_quote($search_word, '/') . '/iu';
                $result = preg_replace($pattern, '<strong>$0</strong>', htmlspecialchars($input));
            } else {
                $result = "Введите слово для поиска!";
            }
            break;

        case '7':
            $patterns = ['/:\)/', '/;\)/', '/:\(/'];
            $replacements = [
                '<img src="smile.png" alt=":)">',
                '<img src="wink.png" alt=";)">',
                '<img src="sad.png" alt=":(">'
            ];
            $replaced = preg_replace($patterns, $replacements, $input);
            $result = "Готовый код:<br> <code>" . htmlspecialchars($replaced) . "</code><br><br>Как выглядит:<br>" . $replaced;
            break;

        case '8': 
            $clean_text = preg_replace('/ {2,}/', ' ', $input);
            $result = "Без лишних пробелов:<br><pre>" . $clean_text . "</pre>";
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Тестер функций</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .result { margin-top: 20px; font-size: 18px; color: #2c3e50; padding: 10px; border: 1px dashed #ccc; }
        strong { background-color: yellow; } /* Для подсветки в задании 6 */
    </style>
</head>
<body>

    <h2>Проверка регулярных выражений</h2>
    
    <form method="POST" action="">
        <p>
            <b>1. Задание:</b><br>
            <select name="task">
                <option value="1" <?= $task === '1' ? 'selected' : '' ?>>1. Расширение файла</option>
                <option value="2" <?= $task === '2' ? 'selected' : '' ?>>2. Тип файла</option>
                <option value="3" <?= $task === '3' ? 'selected' : '' ?>>3. Текст в &lt;title&gt;</option>
                <option value="4" <?= $task === '4' ? 'selected' : '' ?>>4. Ссылки &lt;a href="..."&gt;</option>
                <option value="5" <?= $task === '5' ? 'selected' : '' ?>>5. Картинки &lt;img src="..."&gt;</option>
                <option value="6" <?= $task === '6' ? 'selected' : '' ?>>6. Подсветить слово</option>
                <option value="7" <?= $task === '7' ? 'selected' : '' ?>>7. Смайлики на картинки</option>
                <option value="8" <?= $task === '8' ? 'selected' : '' ?>>8. Удалить лишние пробелы</option>
            </select>
        </p>

        <p>
            <b>2. Введи текст или HTML:</b><br>
            <textarea name="input_text" rows="5" cols="60" required><?= htmlspecialchars($input) ?></textarea>
        </p>

        <p>
            <b>3. Искомое слово (только для 6 задания):</b><br>
            <input type="text" name="search_word" value="<?= htmlspecialchars($search_word) ?>" size="30">
        </p>

        <button type="submit">Проверить</button>
    </form>

    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <div class="result">
            <?= $result ?>
        </div>
    <?php endif; ?>

</body>
</html>