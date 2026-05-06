<?php

// Задание 1. 
function getExtension($filename) {
    if (preg_match('/\.([^.]+)$/i', $filename, $matches)) {
        return $matches[1];
    }
    return null;
}

$fn1 = 'picture.jpg';
echo '<b>1. Из имени файла получите его расширение</b><br>';
echo 'Имя файла: ' . $fn1 . '<br>';
echo 'Результат: ' . getExtension($fn1) . '<br><br>';


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

$fns = [
    'а)' => 'archive.zip',
    'б)' => 'music.mp3',
    'в)' => 'movie.mp4',
    'г)' => 'photo.png',
    'д)' => 'script.php'
];

echo '<b>2. По имени файла проверьте соответствует ли оно типу:</b><br>';
foreach($fns as $letter => $fn) {
    echo $letter . ' Имя файла: ' . $fn . ' — Тип: <i>' . getFileType($fn) . '</i><br>';
}
echo '<br>';


// Задание 3. 
function getTitleFromHtml($html) {
    if (preg_match('/<title>(.*?)<\/title>/is', $html, $matches)) {
        return $matches[1];
    }
    return null;
}

$htmlDoc = "<html>\n<head>\n<title>Моя страница</title>\n</head>\n<body>Привет!</body>\n</html>";

echo '<b>3. В произвольном HTML-коде найдите строку в тегах &lt;title&gt;</b><br>';
echo 'HTML-код: <pre>' . htmlspecialchars($htmlDoc) . '</pre>';
echo 'Результат: ' . getTitleFromHtml($htmlDoc) . '<br><br>';


// Задание 4.
function getAllLinks($html) {
    preg_match_all('/<a\s+[^>]*href=(["\'])(.*?)\1/is', $html, $matches);
    return $matches[2];
}

$htmlLinks = 'Текст <a href="https://google.com">Гугл</a> и еще <a class="link" href="/about.php">О нас</a>';

echo '<b>4. В произвольном HTML-коде найдите все ссылки в тегах &lt;a&gt;</b><br>';
echo 'HTML-код: <br><pre>' . htmlspecialchars($htmlLinks) . '</pre>';
echo 'Ссылки: <ul>';
foreach(getAllLinks($htmlLinks) as $link) {
    echo '<li>' . htmlspecialchars($link) . '</li>';
}
echo '</ul><br>';


// Задание 5.
function getAllImages($html) {
    preg_match_all('/<img\s+[^>]*src=(["\'])(.*?)\1/is', $html, $matches);
    return $matches[2];
}

$htmlImages = 'Смотри: <img src="cat.jpg" alt="Кот"> и еще <img class="img" src="dog.png">';

echo '<b>5. В HTML-коде найдите все ссылки на картинки (атрибут src)</b><br>';
echo 'HTML-код: <br><pre>' . htmlspecialchars($htmlImages) . '</pre>';
echo 'Картинки: <ul>';
foreach(getAllImages($htmlImages) as $img) {
    echo '<li>' . htmlspecialchars($img) . '</li>';
}
echo '</ul><br>';


// Задание 6. 
function highlightText($search, $text) {
    $pattern = '/(' . preg_quote($search, '/') . ')/iu';
    return preg_replace($pattern, '<strong style="color:red;">$1</strong>', $text);
}

$textToHighlight = "Меня зовут Турал. Я крутой парень :) ";
$target = "Турал";

echo '<b>6. Подсветите с помощью тега &lt;strong&gt; заданную строку</b><br>';
echo 'Исходный текст: ' . $textToHighlight . '<br>';
echo 'Ищем слово: <i>' . $target . '</i><br>';
echo 'Результат: ' . highlightText($target, $textToHighlight) . '<br><br>';


// Задание 7.
function replaceSmiles($text) {
    $patterns = ['/:\)/', '/;\)/', '/:\(/'];
    $replacements = [
        '<img src="smile.png" alt=":)">',
        '<img src="wink.png" alt=";)">',
        '<img src="sad.png" alt=":(">'
    ];
    return preg_replace($patterns, $replacements, $text);
}

$textWithSmiles = "Привет :) Как дела? ;) У меня все плохо :(";

echo '<b>7. Замените текстовые смайлики на картинки</b><br>';
echo 'Исходный текст: ' . $textWithSmiles . '<br>';
echo 'Результат (код): <br><pre>' . htmlspecialchars(replaceSmiles($textWithSmiles)) . '</pre><br>';


// Задание 8.
function removeExtraSpaces($text) {
    return preg_replace('/ {2,}/', ' ', $text);
}

$textWithSpaces = "Я     люблю      пробелы.";

echo '<b>8. Избавьтесь от случайных повторяющихся пробелов</b><br>';
echo 'Исходная строка: <pre>' . $textWithSpaces . '</pre>';
echo 'Результат: <pre>' . removeExtraSpaces($textWithSpaces) . '</pre><br>';

?>