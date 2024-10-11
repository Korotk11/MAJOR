<?php
require_once 'connect.php';

$id = $_GET['id'];

$query = "SELECT * FROM `user` WHERE `id_user` = '$id'";
$result = mysqli_query($connect, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($connect));
}

$users = mysqli_fetch_assoc($result);

echo '<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update User</title>
</head>
<body>
    <h3>Update User</h3>
    <form action="update.php" method="post">
        <input type="hidden" name="id" value="' . $users['id_user'] . '">
        <p>Имя</p>
        <input type="text" name="first_name" value="' . $users['first_name'] . '">
        <p>Фамилия</p>
        <input type="text" name="last_name" value="' . $users['last_name'] . '">
        <p>Почта</p>
        <input type="text" name="email" value="' . $users['email'] . '">
        <p>Пароль</p>
        <input type="text" name="password" value="' . $users['password'] . '">
        <p>Телефон</p>
        <input type="text" name="phone" value="' . $users['phone'] . '">
        <p>Роль</p>
        <input type="role" name="role" value="' . $users['role'] . '"> <br> <br>
        <button type="submit">Update</button>
    </form>
</body>
</html>';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];

    $query = "UPDATE `user` SET `first_name` = '$first_name', `last_name` = '$last_name', `email` = '$email', `password` = '$password', `phone` = '$phone', `role` = '$role' WHERE `id_user` = '$id'";

    if (mysqli_query($connect, $query)) {
        echo "User updated successfully";
        header('Location: /admin/index.php');
        exit;
    } else {
        echo "Error updating user: " . mysqli_error($connect);
    }
}

mysqli_close($connect);
?>
