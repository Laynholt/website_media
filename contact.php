<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="styles.css" rel="stylesheet" />
    <link rel="shortcut icon" href="img/icon.png" type="image/x-icon">
    <title>Медиатека</title>

    <?php
      include 'stuff.php';
      session_start();
      unset($_SESSION['message']);
    ?>

  </head>
<body>

<div class="img-bg" style="background-image: url(img/bg1.jpg);background-repeat: no-repeat;" data-img-width="6240" data-img-height="3512">

  <div class="navigation">
      <div class="nav">
          <ul>
            <li><a href="index.php">Главная</a></li>
            <li><a href="release.php">Релизы</a></li>
            <li><a href="random.php">Рандом</a></li>
            <li><a href="store.php">Магазин</a></li>
            <li><a href="contact.php">Контакты</a></li>

            <?php
                if(isset($_SESSION['login']))
                {
            ?>
                    <li style="float:right"><a class="active-sign-in" href="account.php">Личный кабинет</a></li>
            <?php
                }
                else
                {
            ?>
                    <li style="float:right"><a class="active-sign-up" href="reg.php">Зарегистрироваться</a></li>
                    <li style="float:right"><a class="active-sign-in" href="autor.php">Войти</a></li>
            <?php
                }
            ?>

          </ul>
      </div>
  </div>

  <div class="main">
      <div class="style-header">
          <h1>Контакты</h1>
      </div>

      <div class="style-text", style="opacity: 0.75;">
          <h2>Поддержка</h2>
          <p>Все итересующие Вас вопросы вы можете задать, написав нам на почту: alek03.00@mail.ru.</p>
          <p>Либо можете оставить свой email, и мы свяжемся с Вами.</p>
          <form method="POST">
          <center>Email: <input type="email" name="email">
          <span id="valid_email_message" class="mesage_error"></span></center>
          <center><input type="submit" name="send" value="Отправить"></center>

          <?php
              if (isset($_POST['send']))
              {
                  mail($_POST['email'], 'Письмо', 'Добрый день, какой у Вам вопрос?', 'From: alek03.00@mail.ru');
                  echo "<center><strong><i>Сейчас Вам должно придти письмо!</i></strong></center><br>";
                  header('Refresh: 1.5; URL = contact.php');
              }
          ?>
      </div>

          </form>
      </div>
  </div>

</div>
</body>
</html>