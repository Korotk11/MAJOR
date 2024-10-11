<?php
// Добавление нового клиента

// Подключаем файл для получения соединения с базой данных (PhpMyAdmin, MySQL)
require_once 'connect.php';

// Создаем переменные со значениями, полученными из $_POST
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$password = $_POST['pass'];
$phone = $_POST['phone'];
$role = $_POST['role'];

// Запрос на добавление новой строки в таблицу users
mysqli_query($connect, "INSERT INTO `user` (`id_user`, `first_name`, `last_name`, `password`, `email`, `phone`, `role`) VALUES (NULL, '$first_name', '$last_name', '$password', '$email', '$phone', 0)");

// Переадресация на главную страницу
header('Location: /admin/index.php');
