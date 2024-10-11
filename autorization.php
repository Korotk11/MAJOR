<?php
session_start();
$log = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST['loginEmail'];
  $password = $_POST['loginPassword'];

  // Удалены комментарии и код, связанный с reCAPTCHA, поскольку они закомментированы в HTML-файле формы

  // Подключение к базе данных - замените параметры соединения на актуальные
  $db = mysqli_connect('localhost', 'root', '', 'major');
 $recaptcha_response = $_POST['g-recaptcha-response'];
        // Функция для проверки reCAPTCHA через cURL
        function verifyRecaptcha($recaptcha_response) {
            $secret_key = '6LcPs_kpAAAAAH0g09WysybknpxhIZUeo7_9dJmJ';
            $url = 'https://www.google.com/recaptcha/api/siteverify';
            $data = [
                'secret' => $secret_key,
                'response' => $recaptcha_response,
                'remoteip' => $_SERVER['REMOTE_ADDR']
            ];
            // Настройки cURL
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Отключаем проверку SSL-сертификатов для отладки

            // Отправляем запрос и получаем ответ
            $result = curl_exec($ch);
            curl_close($ch);

            if ($result === FALSE) {
                return false;
            }

            return json_decode($result, true);
        }

        // Проверяем reCAPTCHA
        $response_data = verifyRecaptcha($recaptcha_response);
        // Логируем результат проверки reCAPTCHA
        error_log("Ответ от reCAPTCHA: " . json_encode($response_data));
        

  // Используйте подготовленные запросы для защиты от SQL-инъекций
  $query = "SELECT id_user, email, password, first_name FROM user WHERE email = ? AND password = ?";
  $stmt = mysqli_prepare($db, $query);
  mysqli_stmt_bind_param($stmt, "ss", $email, $password);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    $_SESSION['loginEmail'] = $email;
    $_SESSION['loginPassword'] = $password;
    $_SESSION['name'] = $user['first_name'];
    $_SESSION['id_user'] = $user['id_user'];
    $_SESSION['role'] = $user['role'];
    $log = 1;
    $_SESSION['auth'] = true;
    echo "<script>alert('OK')</script>"; 
    // Перенаправление на страницу профиля пользователя:
    header('Location: http://localhost:5173/personal.php');
  } else {
    echo "<script>alert('Неправильный email или пароль')</script>";
  }
}