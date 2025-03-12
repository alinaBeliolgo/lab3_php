<?php
require_once 'config.php';
?>


<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Галерея</title>  
    <link rel="stylesheet" href="styles/styles.css"> 
</head>
<body>
    <header>
        <h1>Галерея</h1>
    </header>
    <nav>
        <a href="#">Главная</a> | <a href="#">Новости</a> | <a href="#">Контакты</a>
    </nav>
    <section class="gallery">
        
        <?php
        /**
         * Перебираем список файлов из папки и выводим только изображения jpg/jpeg.
         * Убираем системные точки ('.', '..') и проверяем расширение файла через регулярку.
         */
        foreach ($files as $file) {
            if ($file != '.' && $file != '..' && preg_match('/\.(jpg|jpeg)$/i', $file)) {
                echo "<img src='$dir$file' alt='Кот'>";
            }
        }

        
        ?>
    </section>
    <footer>
        <p>&copy; 2025</p>
    </footer>
</body>
</html>