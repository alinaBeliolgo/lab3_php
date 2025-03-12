<?php
$dir = 'images/';
$files = scandir($dir);
if ($files === false) {
    die("Ошибка при сканировании директории");
}

