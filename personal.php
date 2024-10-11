
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MAJOR</title>
    <link rel="stylesheet" href="/src/scss/style.css" />
    <script src="/src/js/modyle.js" defer></script>
  </head>
  <body>
    <header class="header">
      <nav class="header_inner container">
        <img src="/src/img/logo.svg" class="header-logo" alt="" />
        <ul class="header-menu1">
          <li class="header-menu_item1">
            <a href="/finishing.html" class="header-menu_link"
              ><h2>Отделка</h2></a
            >
          </li>
          <li class="header-menu_item1">
            <a href="/index.html" class="header-menu_link"
              ><h2>Расположение</h2></a
            >
          </li>
          <li class="header-menu_item1">
            <a href="/galery.html" class="header-menu_link"><h2>Галерея</h2></a>
          </li>
        </ul>
        <ul class="header-menu2">
          <li class="header-menu_item2">
            <a href="/index.html" class="header-menu_link1"
              ><h2>Контакты</h2></a
            >
          </li>
          <li class="header-menu_item2">
            <a href="/galery.html" class="header-menu_link1"
              ><h2>Новости</h2></a
            >
          </li>
          <li class="header-menu_item2">
            <a class="section__button section__button1">
              <h2>Вход</h2>
            </a>
          </li>
        </ul>
      </nav>
    </header>
    <main>
      <form method="post" action="/autorization.php" class="form form_auth">
        <div class="modal modal1">
          <div class="modal__main">
            <h2 class="modal__title">Авторизация</h2>

            <div class="modal__container">
              <p class="modal__text">Введите ваш email</p>
              <input
                type="text"
                id="loginEmail"
                name="loginEmail"
                placeholder="Email"
              />
              <p class="modal__text">Введите ваш пароль</p>
              <input
                type="text"
                id="loginPassword"
                name="loginPassword"
                placeholder="Пароль"
              />
            </div>

            <button
              class="form__submit modal__btn"
              type="submit"
              id="login-submit"
            >
              Авторизоваться
            </button>
            <button class="modal__btn" onclick="redirectToAnotherPage()">
              Зарегистрироваться
            </button>
            <button class="modal__close">&#10006;</button>
          </div>
        </div>
      </form>
      <section class="registration">
        <?php
session_start();
$db = mysqli_connect('localhost', 'root', '', 'major');

if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    header('Location: login.php');
    exit;
}

// Предполагается, что пользователь уже аутентифицирован и его id_users сохранен в сессии
$userId = $_SESSION['id_user'];

$query = "SELECT first_name, last_name, email, phone, role FROM user WHERE id_user = ?";
$stmt = mysqli_prepare($db, $query);
mysqli_stmt_bind_param($stmt, "i", $userId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);


if ($user = mysqli_fetch_assoc($result)) {
    echo "<div class='personal-box container'>";
    echo "<h1>Личный кабинет</h1>";
    echo "<h2>Пользователь</h2>";
    echo "<p>Имя: " . htmlspecialchars($user['first_name']) . "</p>";
    echo "<p>Фамилия: " . htmlspecialchars($user['last_name']) . "</p>";
    echo "<p>Email: " . htmlspecialchars($user['email']) . "</p>";
    echo "<p>Телефон: " . htmlspecialchars($user['phone']) . "</p>";

    // if (isset($user['role']) && $user['role'] == 1) {
    //     echo "<a class='section__button section__button3'>Панель администратора</a>";
    // }
    // Проверяем роль пользователя
    
  
    if (isset($user['role']) && $user['role'] == 1) {
      echo "<p>Роль пользователя: </p>";
      echo "<br>";
      echo "<br>";
        echo "<a style='font-size: 40px; font-family: Montserrat; text-decoration: none; background-color: #FFFFFF; border-radius: 20px; border: 2px solid #375f0f; padding: 20px; color: #0000FF;' class='section__button section__button3' href='/admin/index.php'>Панель администратора</a>";
    } 

    echo "</div>";
    
}
 
else {
    echo "Пользователь не найден.";
}
$query = "SELECT uh.user_id, uh.status_date, h.home_name, uh.status FROM user_home_status uh JOIN home h ON uh.home_id = h.home_id WHERE uh.user_id = ?";
if ($stmt = mysqli_prepare($db, $query)) {
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    echo "<table>";
    echo "<tr><th>Номер заявки</th><th>Дата</th><th>Название дома</th><th>Статус</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['user_id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['status_date']) . "</td>";
        echo "<td>" . htmlspecialchars($row['home_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['status']) . "</td>";
        echo "</tr>";
        
    }
    echo "</table>";
    

    mysqli_stmt_close($stmt);
} else {
    echo "Ошибка: " . mysqli_error($db);
}

// Закрытие соединения с базой данных
mysqli_close($db);
?>
    
         </section>
         <a class="section__button section__button2">Оставить заявку</a>
    <form method="post" action="/application.php" class="form form_app">
        <div class="modal modal2">
          <div class="modal__main">
            <h2 class="modal__title">Заявка</h2>

            <div class="modal__container">
               <?php
session_start();
$db = mysqli_connect('localhost', 'root', '', 'major');

if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    header('Location: login.php');
    exit;
}

// Предполагается, что пользователь уже аутентифицирован и его id_users сохранен в сессии
$userId = $_SESSION['id_user'];

$query = "SELECT first_name, last_name, email, phone FROM user WHERE id_user = ?";
$stmt = mysqli_prepare($db, $query);
mysqli_stmt_bind_param($stmt, "i", $userId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($user = mysqli_fetch_assoc($result)) {
    echo "<div class='personal-box container'>";
    echo "<p>Имя: " . htmlspecialchars($user['first_name']) . "</p>";
    echo "<p>Фамилия: " . htmlspecialchars($user['last_name']) . "</p>";
    echo "<p>Email: " . htmlspecialchars($user['email']) . "</p>";
    echo "<p>Телефон: " . htmlspecialchars($user['phone']) . "</p>";
    echo "</div>";
} else {
    echo "Пользователь не найден.";
}
?>
            </div>
            <input type="date" name="date" />
        <div class="home">
            <?php
// Соединение с базой данных
$db = mysqli_connect('localhost', 'root', '', 'major');

// Получение списка домов
$query = "SELECT home_id, home_name, home_number FROM home";
$result = mysqli_query($db, $query);
$houses = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<form action="handle_form.php" method="post">
    <label for="home_number">Выберите номер дома:</label>
    <select name="home_number" id="home_number">
        <?php foreach ($houses as $house): ?>
            <option value="<?= $house['home_number'] ?>">
                <?= $house['home_name'] ?>
            </option>
        <?php endforeach; ?>
    </select>

</form>
        </div>
            <button
              class="form__submit modal__btn"
              type="submit"
              id="login-submit"
            >
              Ок
            </button>
            <button class="modal__close">&#10006;</button>
            
          </div>
        </div>
      </form>
      <div class="personal-box">
       
      </div>

    </main>
    <footer class="footer">
      <div class="footer_inner container">
        <ul class="footer-menu1">
          <li class="footer-menu_item1">
            <a href="" class="footer-menu_link"><h2>Отделка</h2></a>
          </li>
          <li class="footer-menu_item1">
            <a href="" class="footer-menu_link"><h2>Расположение</h2></a>
          </li>
          <li class="footer-menu_item1">
            <a href="" class="footer-menu_link"><h2>Галерея</h2></a>
          </li>
        </ul>
        <ul class="footer-menu2">
          <li class="footer-menu_item2">
            <a href="" class="footer-menu_link1"><h2>Контакты</h2></a>
          </li>
          <li class="footer-menu_item2">
            <a href="" class="header-menu_link1"><h2>Новости</h2></a>
          </li>
          <li class="footer-menu_item2">
            <a href="" class="footer-menu_link1"><h2>Вход</h2></a>
          </li>
        </ul>
      </div>
      <div class="footer-copirate">
        <p class="footer-copirate_text">© MAJOR 2024</p>
      </div>
    </footer>
    <script type="module" src="/src/js/main.js"></script>
    <script type="module" src="/src/js/modyle.js"></script>
  </body>
</html>
