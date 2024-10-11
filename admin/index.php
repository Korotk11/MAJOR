<?php
/*
 * Подключаем файл для получения соединения к базе данных (PhpMyAdmin, MySQL)
 */

require_once 'connect.php';

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User</title>
</head>
<style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        th {
            background: #606060;
            color: #fff;
        }
        td {
            background: #b5b5b5;
        }
        h3 {
            margin-top: 20px;
        }
        button {
            margin-top: 20px;
        }
    </style>
<body>
    <button><a href="/personal.php" style="font-size: 20px; text-decoration: none" >Вернуться в профиль</a></button> 
    <br>
    <br>
    <table>
        <tr>
            <th>ID</th>
            <th>Имя</th>
            <th>Фамилия</th>
            <th>Почта</th>
            <th>Телефон</th>
            <th>Роль</th>
        </tr>

        <?php

            /*
             * Делаем выборку всех строк из таблицы "user"
             */

            $major = mysqli_query($connect, "SELECT * FROM `user`");

            /*
             * Преобразовываем полученные данные в нормальный массив
             */

            $major = mysqli_fetch_all($major);

            /*
             * Перебираем массив и рендерим HTML с данными из массива
             */

            foreach ($major as $major) {
                ?>
                    <tr>
                        <td><?= $major[0] ?></td>
                        <td><?= $major[1] ?></td>
                        <td><?= $major[2] ?></td>
                        <td><?= $major[4] ?></td>
                        <td><?= $major[5] ?></td>
                        <td><?= $major[6] ?></td>
                        
                        <td><a href="update.php?id=<?= $major[0] ?>">Обновить</a></td>
                        <td><a style="color: red;" href="delete.php?id=<?= $major[0] ?>">Удалить</a></td>
                    </tr>
                <?php
            }
        ?>
    </table>
    <h3>Добавить нового пользователя</h3>
    <form action="create.php" method="post">
        <p>Имя</p>
        <input type="text" name="first_name">
        <p>Фамилия</p>
        <input type="text" name="last_name">
        <p>Почта</p>
        <input type="text" name="email">
        <p>Пароль</p>
        <input type="text" name="password">
        <p>Телефон</p>
        <input type="text" name="phone">
        <p>Роль</p>
        <input type="text" name="role"> <br> <br>
        <button type="submit">Добавить нового пользователя</button>
    </form>
    <br>
    <br>
<button><a href="/admin/predstavleniy.php" style="font-size: 20px; text-decoration: none; ">Представления</a></button>
    <h3>Агенты</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Имя</th>
            <th>Телефон</th>
            <th>Email</th>
        </tr>
    <?php

$major = mysqli_query($connect, "SELECT * FROM `agent`");

$major = mysqli_fetch_all($major);

foreach ($major as $major) {
    ?>
    
        <tr>
            <td><?= $major[0] ?></td>
            <td><?= $major[1] ?></td>
            <td><?= $major[2] ?></td>
            <td><?= $major[3] ?></td>
        </tr>
    <?php
}
?>
</table>

    <h3>Дома</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Имя</th>
            <th>Номер</th>
        </tr>
    <?php

$major = mysqli_query($connect, "SELECT * FROM `home`");

$major = mysqli_fetch_all($major);

foreach ($major as $major) {
    ?>
    
        <tr>
            <td><?= $major[0] ?></td>
            <td><?= $major[1] ?></td>
            <td><?= $major[2] ?></td>
        </tr>
    <?php
}
?>

<table>
    <h3>Сделки</h3>
    <tr>
        <th>ID</th>
        <th>ID пользователя</th>
        <th>ID дома</th>
        <th>ID агента</th>
        <th>Дата сделки</th>
        <th>Сумма сделки</th>
    </tr>
<?php

$deal = mysqli_query($connect, "SELECT * FROM `deal`");

$deal = mysqli_fetch_all($deal);

foreach ($deal as $deal) {
    ?>
    
        <tr>
            <td><?= $deal[0] ?></td>
            <td><?= $deal[1] ?></td>
            <td><?= $deal[2] ?></td>
            <td><?= $deal[3] ?></td>
            <td><?= $deal[4] ?></td>
            <td><?= $deal[5] ?></td>
        </tr>
    <?php
}
?>

<table>
    <h3>Районы</h3>
    <tr>
        <th>ID</th>
        <th>Название района</th>
    </tr>
<?php

$district = mysqli_query($connect, "SELECT * FROM `district`");

$district = mysqli_fetch_all($district);

foreach ($district as $district) {
    ?>
    
        <tr>
            <td><?= $district[0] ?></td>
            <td><?= $district[1] ?></td>
        </tr>
    <?php
}
?>

<table>
    <h3>Характеристики домов</h3>
    <tr>
        <th>ID дома</th>
        <th>Количество комнат</th>
        <th>Площадь</th>
        <th>Статус</th>
    </tr>
<?php

$home_features = mysqli_query($connect, "SELECT * FROM `home_features`");

$home_features = mysqli_fetch_all($home_features);

foreach ($home_features as $home_features) {
    ?>
    
        <tr>
            <td><?= $home_features[0] ?></td>
            <td><?= $home_features[1] ?></td>
            <td><?= $home_features[2] ?></td>
            <td><?= $home_features[3] ?></td>
        </tr>
    <?php
}
?>

<table>
    <h3>Типы домов</h3>
    <tr>
        <th>ID</th>
        <th>Название типа</th>
    </tr>
<?php

$home_type = mysqli_query($connect, "SELECT * FROM `home_type`");

$home_type = mysqli_fetch_all($home_type);

foreach ($home_type as $home_type) {
    ?>
    
        <tr>
            <td><?= $home_type[0] ?></td>
            <td><?= $home_type[1] ?></td>
        </tr>
    <?php
}
?>

<table>
    <h3>Статусы пользователей и домов</h3>
    <tr>
        <th>ID пользователя</th>
        <th>ID дома</th>
        <th>Дата статуса</th>
        <th>Статус</th>
    </tr>
<?php

$user_home_status = mysqli_query($connect, "SELECT * FROM `user_home_status`");

$user_home_status = mysqli_fetch_all($user_home_status);

foreach ($user_home_status as $user_home_status) {
    ?>
    
        <tr>
            <td><?= $user_home_status[0] ?></td>
            <td><?= $user_home_status[1] ?></td>
            <td><?= $user_home_status[2] ?></td>
            <td><?= $user_home_status[3] ?></td>
        </tr>
    <?php
}
?>



