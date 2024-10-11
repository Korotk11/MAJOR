<?php
session_start();
$db = mysqli_connect('localhost','root', '', 'major' );



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$password = $_POST['password'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$passwordConfirm = $_POST['passwordConfirm'];

$_SESSION ['first_name'] = $first_name;

if ($db == false){
    echo 'Ошибка подключения';
    exit;
}

$UserMail = mysqli_query ($db, "SELECT email from user where email = '$email' ");

if (empty($first_name) || empty($last_name)  || empty($password) || empty($email)  || empty($phone)  || empty($passwordConfirm)) {
    echo 'Заполните все поля';
    exit;
}
// $phone = preg_replace('/\D/', '', $phone);
// Проверка на правильное заполнение почты
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo 'Неправильный формат электронной почты';
    exit;
}

// Проверка на запрещенные символы в пароле
if (preg_match('/[\'",\*,\[\],\{\}]/', $password)) {
    echo "<p>Недопустимые символы в пароле</p>";
    exit;
}

if (mysqli_num_rows ($UserMail) > 0){ 
    echo "Такая почта уже занята";
    exit; 
} 


if ($password == $passwordConfirm && strlen ($password) > 6 ){ 

    $sqlInsert = "INSERT INTO user SET first_name = '$first_name', last_name = '$last_name',  password = '$password', email = '$email',  phone = '$phone' "; 

    $result = mysqli_query($db, $sqlInsert);
    // header ('Location:file:///C:/ospanel/domains/localhost/Pretty/contact.html');
    echo '<script>window.location.href = "mainpage.html"; setTimeout(function() { document.querySelector(".section__button.section__button1").click(); }, 1000);</script>';
}
else{
    echo "Пароль меньше 6 символов или не совпадают.";
}
}

else{ 
    echo 'Не правильно заполнены поля'; 
    exit; 
} 
?>