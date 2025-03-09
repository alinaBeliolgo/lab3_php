<?php
$dir = 'images/';
$files = scandir($dir);
if ($files === false) {
    die("Ошибка при сканировании директории");
}
?>



<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Галерея</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        .gallery { display: flex; flex-wrap: wrap; justify-content: center; gap: 10px; }
        .gallery img { width: 200px; height: 200px; object-fit: cover; border-radius: 10px; }
        header, footer { padding: 10px; background: #f4f4f4; margin-bottom: 20px; }
    </style>
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
        foreach ($files as $file) {
            if ($file != '.' && $file != '..' && preg_match('/\.(jpg|jpeg|png|gif)$/i', $file)) {
                echo "<img src='$dir$file' alt='Котик'>";
            }
        }
        ?>
    </section>
    <footer>
        <p>&copy; 2025</p>
    </footer>
</body>
</html>