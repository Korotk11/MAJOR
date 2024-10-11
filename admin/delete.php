<?php
// Удаление пользователя

// Подключаем файл для получения соединения к базе данных (PhpMyAdmin, MySQL)
require_once 'connect.php';

// Получаем ID продукта из адресной строки
$id = $_GET['id'];

// Делаем запрос на удаление строки из таблицы user
mysqli_query($connect, "DELETE FROM `user` WHERE `id_user` = '$id'");

// Переадресация на главную страницу
header('Location: /admin/index.php');