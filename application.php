<?php
session_start();
$db = mysqli_connect('localhost', 'root', '', 'major');

if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['id_user']; // Получение id пользователя из сессии

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $date = $_POST['date'] ?? null; // Получение даты из формы с проверкой на существование
    $homeNumber = $_POST['home_number']; // Получение номера дома из формы

    // Проверка наличия даты
    if ($date === null) {
        echo "Ошибка: Дата не указана.";
        exit;
    }

    // Поиск home_id по home_number
    $homeQuery = "SELECT home_id FROM home WHERE home_number = ?";
    $homeStmt = mysqli_prepare($db, $homeQuery);
    mysqli_stmt_bind_param($homeStmt, "i", $homeNumber);
    mysqli_stmt_execute($homeStmt);
    $homeResult = mysqli_stmt_get_result($homeStmt);
    $homeRow = mysqli_fetch_assoc($homeResult);
    $homeId = $homeRow['home_id'];

    if ($homeId) {
        // Вставка данных в таблицу user_home_status
        $insertQuery = "INSERT INTO user_home_status (user_id, home_id, status_date) VALUES (?, ?, ?)";
        $insertStmt = mysqli_prepare($db, $insertQuery);
        mysqli_stmt_bind_param($insertStmt, "iis", $userId, $homeId, $date);
        mysqli_stmt_execute($insertStmt);
        if (mysqli_stmt_affected_rows($insertStmt) > 0) {
            echo "Запись успешно добавлена.";
        } else {
            echo "Ошибка при добавлении записи.";
        }
    } else {
        echo "Дом не найден.";
    }
    // Проверка наличия записи в таблице user_home_status
$checkQuery = "SELECT COUNT(*) FROM user_home_status WHERE user_id = ? AND home_id = ?";
$checkStmt = mysqli_prepare($db, $checkQuery);
mysqli_stmt_bind_param($checkStmt, "ii", $userId, $homeId);
mysqli_stmt_execute($checkStmt);
mysqli_stmt_bind_result($checkStmt, $count);
mysqli_stmt_fetch($checkStmt);

if ($count == 0) {
    // Вставка данных, так как запись не найдена
    $insertQuery = "INSERT INTO user_home_status (user_id, home_id, status_date) VALUES (?, ?, ?)";
    $insertStmt = mysqli_prepare($db, $insertQuery);
    mysqli_stmt_bind_param($insertStmt, "iis", $userId, $homeId, $date);
    mysqli_stmt_execute($insertStmt);
    if (mysqli_stmt_affected_rows($insertStmt) > 0) {
        echo "Запись успешно добавлена.";
    } else {
        echo "Ошибка при добавлении записи.";
    }
} else {
    echo "Запись уже существует.";
}

}
?>
