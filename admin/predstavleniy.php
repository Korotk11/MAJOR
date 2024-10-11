<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
        }
    </style>
<body>
<a href="/admin/index.php">Админ панель</a>  
<?php
$servername = "localhost"; // Обычно localhost
$dbname = "major"; // Имя вашей базы данных
$dbusername = "root"; // Ваше имя пользователя базы данных
$dbpassword = ""; // Ваш пароль базы данных

// Создание подключения
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Проверка подключения
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Получить список всех домов в определенном районе
echo "<h2>Список всех домов в определенном районе.</h2>";
$query = "SELECT h.* 
          FROM home h
          JOIN district d ON h.home_id = d.district_id
          WHERE d.district_name = 'Central'";

$result = $conn->query($query);

if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>home_id</th><th>home_name</th><th>home_number</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["home_id"]. "</td><td>" . $row["home_name"]. "</td><td>" . $row["home_number"]. "</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 результатов";
}

// Получить список всех клиентов, заинтересованных в домах определенного типа
echo "<h2>Список всех клиентов, заинтересованных в домах типа 'Apartment'.</h2>";
$query = "SELECT u.* 
          FROM user u
          JOIN user_home_status uhs ON u.id_user = uhs.user_id
          JOIN home h ON uhs.home_id = h.home_id
          JOIN home_type ht ON h.home_type_id = ht.home_type_id
          WHERE ht.home_type_name = 'Apartment'";

$result = $conn->query($query);

if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>id_user</th><th>first_name</th><th>last_name</th><th>email</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["id_user"]. "</td><td>" . $row["first_name"]. "</td><td>". $row["last_name"]. "</td><td>" . $row["email"]. "</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 результатов";
}

// Получить список всех сделок, заключенных агентом недвижимости с определенным идентификатором
echo "<h2>Список всех сделок, заключенных агентом недвижимости с идентификатором 1.</h2>";
$query = "SELECT * 
          FROM deal
          WHERE agent_id = 1";

$result = $conn->query($query);

if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>deal_id</th><th>user_id</th><th>home_id</th><th>agent_id</th><th>deal_date</th><th>deal_amount</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["deal_id"]. "</td><td>" . $row["user_id"]. "</td><td>" . $row["home_id"]. "</td><td>" . $row["agent_id"]. "</td><td>" . $row["deal_date"]. "</td><td>" . $row["deal_amount"]. "</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 результатов";
}
echo "<h2>Список всех домов с указанием их стоимости и агента недвижимости, ответственного за продажу.</h2>";
$query = "SELECT h.home_name, h.home_number, d.deal_amount, a.agent_name 
          FROM home h
          JOIN deal d ON h.home_id = d.home_id
          JOIN agent a ON d.agent_id = a.agent_id";

$result = $conn->query($query);

if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>home_name</th><th>home_number</th><th>deal_amount</th><th>agent_name</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["home_name"]. "</td><td>" . $row["home_number"]. "</td><td>" . $row["deal_amount"]. "</td><td>" . $row["agent_name"]. "</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 результатов";
}

// Получить список всех клиентов, совершивших сделку на определенную сумму и с указанием дома, который был продан.
echo "<h2>Список всех клиентов, совершивших сделку на определенную сумму и с указанием дома, который был продан.</h2>";
$query = "SELECT u.first_name, u.last_name, d.deal_amount, h.home_name 
          FROM user u
          JOIN deal d ON u.id_user = d.user_id
          JOIN home h ON d.home_id = h.home_id
          WHERE d.deal_amount = 100000";

$result = $conn->query($query);

if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>first_name</th><th>last_name</th><th>deal_amount</th><th>home_name</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["first_name"]. "</td><td>" . $row["last_name"]. "</td><td>" . $row["deal_amount"]. "</td><td>" . $row["home_name"]. "</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 результатов";
}

// Получить список всех домов, доступных для продажи на определенную дату.
echo "<h2>Список всех домов, доступных для продажи на определенную дату.</h2>";
$query = "SELECT h.* 
          FROM home h
          JOIN user_home_status uhs ON h.home_id = uhs.home_id
          WHERE uhs.status_date = '2024-10-04'";

$result = $conn->query($query);

if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>home_id</th><th>home_name</th><th>home_number</th><th>home_type_id</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["home_id"]. "</td><td>" . $row["home_name"]. "</td><td>" . $row["home_number"]. "</td><td>" . $row["home_type_id"];
    }
    echo "</table>";
} else {
    echo "0 результатов";
}

// Получить список всех агентов недвижимости и общей суммы сделок, заключенных каждым агентом.
echo "<h2>Список всех агентов недвижимости и общей суммы сделок, заключенных каждым агентом.</h2>";
$query = "SELECT a.agent_name, SUM(d.deal_amount) AS total_deals 
          FROM agent a
          JOIN deal d ON a.agent_id = d.agent_id
          GROUP BY a.agent_name";

$result = $conn->query($query);

if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>agent_name</th><th>total_deals</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["agent_name"]. "</td><td>" . $row["total_deals"]. "</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 результатов";
}

// Получить список всех доступных домов определенного типа.
echo "<h2>Список всех доступных домов определенного типа.</h2>";

$type = 'Apartment'; // specify the home type

$query = "SELECT h.* 
          FROM home h
          JOIN home_type ht ON h.home_type_id = ht.home_type_id
          WHERE ht.home_type_name = '$type'";

$result = $conn->query($query);

if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>home_id</th><th>home_name</th><th>home_number</th><th>home_type_id</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["home_id"]. "</td><td>" . $row["home_name"]. "</td><td>" . $row["home_number"]. "</td><td>" . $row["home_type_id"];
    }
    echo "</table>";
} else {
    echo "0 результатов";
}

// Получить список всех клиентов, у которых бюджет позволяет приобрести дома в определенном ценовом диапазоне.
echo "<h2>Список всех клиентов, у которых бюджет позволяет приобрести дома в определенном ценовом диапазоне.</h2>";

$min_amount = 50000; // specify the minimum deal amount
$max_amount = 100000; // specify the maximum deal amount

$query = "SELECT u.* 
          FROM user u
          JOIN deal d ON u.id_user = d.user_id
          WHERE d.deal_amount BETWEEN $min_amount AND $max_amount";

$result = $conn->query($query);

if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>id_user</th><th>first_name</th><th>last_name</th><th>email</th><th>phone</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["id_user"]. "</td><td>" . $row["first_name"]. "</td><td>" . $row["last_name"]. "</td><td>". $row["email"]. "</td><td>". $row["phone"];
    }
    echo "</table>";
} else {
    echo "0 результатов";
}

// Получить список всех домов, с указанием количества комнат и площади каждого дома, статуса продажи, стоимости.
echo "<h2>Список всех домов, с указанием количества комнат и площади каждого дома, статуса продажи, стоимости.</h2>";

$query = "SELECT h.home_name, hf.num_rooms, hf.area, uhs.status, d.deal_amount 
          FROM home h
          JOIN home_features hf ON h.home_id = hf.home_id
          JOIN user_home_status uhs ON h.home_id = uhs.home_id
          JOIN deal d ON h.home_id = d.home_id";

$result = $conn->query($query);

if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>home_name</th><th>num_rooms</th><th>area</th><th>status</th><th>deal_amount</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["home_name"]. "</td><td>" . $row["num_rooms"]. "</td><td>" . $row["area"]. "</td><td>" . $row["status"]. "</td><td>" . $row["deal_amount"]. "</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 результатов";
}

// Close connection
$conn->close();
?>

</body>
</html>